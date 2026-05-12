<?php

namespace App\Http\Controllers\Admin;

use App\Models\CapaAction;
use App\Models\Complaint;
use App\Models\Staff;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for CAPA Actions.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class CapaActionController extends BaseCrudController
{
    protected string $modelClass = CapaAction::class;

    protected string $routeSlug = 'capa-actions';

    protected ?string $permissionModule = 'capa_actions';

    protected string $singular = 'CAPA Action';

    protected string $plural = 'CAPA Actions';

    protected array $with = [];

    protected array $searchable = ['capa_no'];

    protected array $columns = [
        'id' => '#',
        'capa_no' => 'No.',
        'due_date' => 'Due',
        'verified_date' => 'Verified',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::text('capa_no', 'No.', true),
            CrudField::select('complaint_id', 'Complaint', static::options(Complaint::class), false),
            CrudField::select('responsible_staff_id', 'Responsible Staff', static::options(Staff::class), false),
            CrudField::textarea('root_cause', 'Root Cause', false, 3),
            CrudField::textarea('corrective_action', 'Corrective Action', false, 3),
            CrudField::textarea('preventive_action', 'Preventive Action', false, 3),
            CrudField::date('due_date', 'Due Date', false),
            CrudField::textarea('verification_of_effectiveness', 'Verification', false, 3),
            CrudField::date('verified_date', 'Verified Date', false),
            CrudField::select('status', 'Status', ['open' => 'Open', 'in_progress' => 'In Progress', 'completed' => 'Completed', 'verified' => 'Verified'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'capa_no' => ['required', 'string', 'max:191'],
            'complaint_id' => ['nullable', 'string', 'max:191'],
            'responsible_staff_id' => ['nullable', 'string', 'max:191'],
            'root_cause' => ['nullable', 'string'],
            'corrective_action' => ['nullable', 'string'],
            'preventive_action' => ['nullable', 'string'],
            'due_date' => ['nullable', 'date'],
            'verification_of_effectiveness' => ['nullable', 'string'],
            'verified_date' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
