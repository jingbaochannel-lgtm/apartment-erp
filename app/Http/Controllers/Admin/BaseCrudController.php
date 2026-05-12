<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\ColumnRenderer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Facades\DataTables;

/**
 * Base controller every admin CRUD module extends.
 *
 * Subclasses configure model + form fields + columns + validation rules
 * and the generic implementation handles index/data/create/store/edit/
 * update/show/destroy plus permission gating and translation lookup.
 */
abstract class BaseCrudController extends Controller
{
    /** Fully-qualified model class name. */
    protected string $modelClass;

    /** Plural snake-case slug used for routes / views (e.g. `tenants`). */
    protected string $routeSlug;

    /** Singular human label (e.g. `Tenant`). */
    protected string $singular;

    /** Plural human label (e.g. `Tenants`). */
    protected string $plural;

    /** Eager-load these relations on index/show. */
    protected array $with = [];

    /** Searchable column names. */
    protected array $searchable = [];

    /** Default per-page for index pagination. */
    protected int $perPage = 15;

    /**
     * Index columns: ['column' => 'Header'] or ['relation.field' => 'Header'].
     *
     * @var array<string,string>
     */
    protected array $columns = [];

    /** Default column to sort by on the index page. */
    protected string $defaultSort = 'id';

    /** Default sort direction. */
    protected string $defaultDir = 'desc';

    /** View namespace; falls back to the generic _crud templates. */
    protected string $viewPath = 'admin._crud';

    /** Permission "module" prefix. Defaults to the route slug. */
    protected ?string $permissionModule = null;

    /**
     * Permission "verb" each controller method maps to.
     *
     * @var array<string,string>
     */
    protected array $actionPermissions = [
        'index' => 'view',
        'data' => 'view',
        'show' => 'view',
        'create' => 'create',
        'store' => 'create',
        'edit' => 'edit',
        'update' => 'edit',
        'destroy' => 'delete',
    ];

    /** Build the form fields. */
    abstract protected function fields(): array;

    /** Validation rules keyed by field name. */
    abstract protected function rules(?Model $record = null): array;

    public function permissionFor(string $action): ?string
    {
        $verb = $this->actionPermissions[$action] ?? null;
        if (! $verb) {
            return null;
        }
        $module = $this->permissionModule ?? $this->routeSlug;

        return "{$module}.{$verb}";
    }

    protected function authorizeAction(string $action): void
    {
        $user = request()->user();
        if (! $user) {
            abort(401);
        }
        $permission = $this->permissionFor($action);
        if ($permission === null) {
            throw new \LogicException(
                'Missing permission mapping for action ['.$action.'] in '.static::class
            );
        }
        if (method_exists($user, 'can') && ! $user->can($permission)) {
            // In dev / when permission system is being seeded we fall through
            // so authenticated users can still browse the scaffold. The audit
            // log records the permission name regardless.
            if (config('apartment.enforce_permissions', false)) {
                abort(403);
            }
        }
    }

    public function index(Request $request)
    {
        $this->authorizeAction('index');

        $query = $this->modelClass::query()->with($this->with);
        if ($request->filled('q') && $this->searchable) {
            $term = '%'.$request->string('q').'%';
            $query->where(function (Builder $q) use ($term) {
                foreach ($this->searchable as $col) {
                    $q->orWhere($col, 'like', $term);
                }
            });
        }
        $sort = $request->input('sort', $this->defaultSort);
        $dir = $request->input('dir', $this->defaultDir) === 'asc' ? 'asc' : 'desc';
        $records = $query->orderBy($sort, $dir)->paginate($this->perPage)->withQueryString();

        return view($this->indexView(), [
            'records' => $records,
            'columns' => $this->columns,
            'meta' => $this->meta(),
        ]);
    }

    public function data(Request $request): JsonResponse
    {
        $this->authorizeAction('data');

        $query = $this->modelClass::query()->with($this->with);
        $columns = $this->columns;
        $searchable = $this->searchable;
        $slug = $this->routeSlug;
        $user = $request->user();
        $canEdit = $user && method_exists($user, 'can') ? $user->can($this->permissionFor('edit')) : true;
        $canDelete = $user && method_exists($user, 'can') ? $user->can($this->permissionFor('destroy')) : true;

        if (! config('apartment.enforce_permissions', false)) {
            $canEdit = true;
            $canDelete = true;
        }

        $confirmText = __('app.dialogs.confirm_delete_text');
        $viewLabel = __('app.actions.view');
        $editLabel = __('app.actions.edit');
        $deleteLabel = __('app.actions.delete');

        $dt = DataTables::eloquent($query);

        foreach (array_keys($columns) as $col) {
            $dt->editColumn($col, fn ($row) => ColumnRenderer::render($row, $col));
        }

        $dt->addColumn('actions', function ($row) use ($slug, $canEdit, $canDelete, $confirmText, $viewLabel, $editLabel, $deleteLabel) {
            $html = '';
            if (Route::has("admin.{$slug}.show")) {
                $html .= '<a href="'.route("admin.{$slug}.show", $row).'" class="btn btn-sm btn-info" title="'.e($viewLabel).'"><i class="bi bi-eye"></i></a> ';
            }
            if ($canEdit && Route::has("admin.{$slug}.edit")) {
                $html .= '<a href="'.route("admin.{$slug}.edit", $row).'" class="btn btn-sm btn-warning" title="'.e($editLabel).'"><i class="bi bi-pencil"></i></a> ';
            }
            if ($canDelete && Route::has("admin.{$slug}.destroy")) {
                $html .= '<form method="POST" action="'.route("admin.{$slug}.destroy", $row).'" data-confirm-delete="'.e($confirmText).'" class="d-inline">'
                    .csrf_field().'<input type="hidden" name="_method" value="DELETE">'
                    .'<button type="submit" class="btn btn-sm btn-danger" title="'.e($deleteLabel).'"><i class="bi bi-trash"></i></button>'
                    .'</form>';
            }

            return $html;
        });

        $dt->filter(function ($q) use ($request, $searchable) {
            $term = (string) $request->input('search.value', '');
            if ($term !== '' && $searchable) {
                $q->where(function ($qq) use ($term, $searchable) {
                    foreach ($searchable as $col) {
                        $qq->orWhere($col, 'like', "%{$term}%");
                    }
                });
            }
        }, true);

        $dt->rawColumns(array_merge(array_keys($columns), ['actions']));

        return $dt->toJson();
    }

    public function create()
    {
        $this->authorizeAction('create');

        $record = new $this->modelClass;

        return view($this->formView(), [
            'record' => $record,
            'fields' => $this->fields(),
            'mode' => 'create',
            'meta' => $this->meta(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeAction('store');

        $data = $this->validateInput($request);
        $record = $this->modelClass::create($this->beforeSave($data, $request));
        $this->afterSave($record, $request);
        flash()->success(__('app.flash.created', ['name' => $this->meta()['singular']]));

        return redirect()->route("admin.{$this->routeSlug}.index");
    }

    public function show($id)
    {
        $this->authorizeAction('show');

        $record = $this->modelClass::with($this->with)->findOrFail($id);

        return view($this->showView(), [
            'record' => $record,
            'fields' => $this->fields(),
            'meta' => $this->meta(),
        ]);
    }

    public function edit($id)
    {
        $this->authorizeAction('edit');

        $record = $this->modelClass::findOrFail($id);

        return view($this->formView(), [
            'record' => $record,
            'fields' => $this->fields(),
            'mode' => 'edit',
            'meta' => $this->meta(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAction('update');

        $record = $this->modelClass::findOrFail($id);
        $data = $this->validateInput($request, $record);
        $record->update($this->beforeSave($data, $request, $record));
        $this->afterSave($record, $request);
        flash()->success(__('app.flash.updated', ['name' => $this->meta()['singular']]));

        return redirect()->route("admin.{$this->routeSlug}.index");
    }

    public function destroy($id)
    {
        $this->authorizeAction('destroy');

        $record = $this->modelClass::findOrFail($id);
        $record->delete();
        flash()->success(__('app.flash.deleted', ['name' => $this->meta()['singular']]));

        return redirect()->route("admin.{$this->routeSlug}.index");
    }

    /* -----------------------------------------------------------------
     | Hooks subclasses may override
     *----------------------------------------------------------------*/

    protected function validateInput(Request $request, ?Model $record = null): array
    {
        return $request->validate($this->rules($record));
    }

    protected function beforeSave(array $data, Request $request, ?Model $record = null): array
    {
        return $data;
    }

    protected function afterSave(Model $record, Request $request): void {}

    /* -----------------------------------------------------------------
     | View / route helpers
     *----------------------------------------------------------------*/

    protected function indexView(): string
    {
        return view()->exists("admin.{$this->routeSlug}.index")
            ? "admin.{$this->routeSlug}.index"
            : "{$this->viewPath}.index";
    }

    protected function formView(): string
    {
        return view()->exists("admin.{$this->routeSlug}.form")
            ? "admin.{$this->routeSlug}.form"
            : "{$this->viewPath}.form";
    }

    protected function showView(): string
    {
        return view()->exists("admin.{$this->routeSlug}.show")
            ? "admin.{$this->routeSlug}.show"
            : "{$this->viewPath}.show";
    }

    protected function meta(): array
    {
        $base = str_replace('-', '_', $this->routeSlug);
        $pluralKey = "app.resources.{$base}";

        $singularKey = null;
        foreach ($this->singularKeyCandidates($base) as $cand) {
            $key = "app.resources.{$cand}";
            if (trans()->has($key)) {
                $singularKey = $key;
                break;
            }
        }

        $singular = $singularKey ? __($singularKey) : $this->singular;
        $plural = trans()->has($pluralKey) ? __($pluralKey) : $this->plural;

        return [
            'singular' => $singular,
            'plural' => $plural,
            'singular_key' => $singularKey,
            'plural_key' => trans()->has($pluralKey) ? $pluralKey : null,
            'routeSlug' => $this->routeSlug,
            'permissionPrefix' => $this->permissionModule ?? $this->routeSlug,
            'searchable' => ! empty($this->searchable),
        ];
    }

    private function singularKeyCandidates(string $plural): array
    {
        $candidates = [];
        if (str_ends_with($plural, 's')) {
            $candidates[] = substr($plural, 0, -1);
        }
        if (str_ends_with($plural, 'ies')) {
            $candidates[] = substr($plural, 0, -3).'y';
        }
        if (str_ends_with($plural, 'es')) {
            $candidates[] = substr($plural, 0, -2);
        }
        $candidates[] = $plural;

        return array_values(array_unique($candidates));
    }

    /** Helper for child controllers: convert relation -> [id => label] for selects. */
    protected static function options(string $modelClass, string $labelCol = 'name', array $where = []): array
    {
        $q = $modelClass::query();
        foreach ($where as $col => $val) {
            $q->where($col, $val);
        }

        return $q->orderBy($labelCol)->pluck($labelCol, 'id')->all();
    }
}
