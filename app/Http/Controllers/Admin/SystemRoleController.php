<?php

namespace App\Http\Controllers\Admin;

use App\Models\SystemRole;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Roles.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class SystemRoleController extends BaseCrudController
{
    protected string $modelClass = SystemRole::class;

    protected string $routeSlug = 'system-roles';

    protected ?string $permissionModule = 'system_roles';

    protected string $singular = 'Role';

    protected string $plural = 'Roles';

    protected array $with = [];

    protected array $searchable = ['role_code', 'name'];

    protected array $columns = [
        'id' => '#',
        'role_code' => 'Code',
        'name' => 'Name',
        'description' => 'Description',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::text('role_code', 'Code', true),
            CrudField::text('name', 'Name', true),
            CrudField::textarea('description', 'Description', false, 3),
            CrudField::checkbox('is_system', 'System Role'),
            CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'role_code' => ['required', 'string', 'max:191'],
            'name' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string'],
            'is_system' => ['nullable', 'boolean'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
