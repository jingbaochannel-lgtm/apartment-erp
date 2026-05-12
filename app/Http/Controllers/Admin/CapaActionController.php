<?php

namespace App\Http\Controllers\Admin;

use App\Models\CapaAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
            \App\Support\CrudField::text('capa_no', 'No.', true),
            \App\Support\CrudField::select('complaint_id', 'Complaint', static::options(\App\Models\Complaint::class), false),
            \App\Support\CrudField::select('responsible_staff_id', 'Responsible Staff', static::options(\App\Models\Staff::class), false),
            \App\Support\CrudField::textarea('root_cause', 'Root Cause', false, 3),
            \App\Support\CrudField::textarea('corrective_action', 'Corrective Action', false, 3),
            \App\Support\CrudField::textarea('preventive_action', 'Preventive Action', false, 3),
            \App\Support\CrudField::date('due_date', 'Due Date', false),
            \App\Support\CrudField::textarea('verification_of_effectiveness', 'Verification', false, 3),
            \App\Support\CrudField::date('verified_date', 'Verified Date', false),
            \App\Support\CrudField::select('status', 'Status', ['open' => 'Open', 'in_progress' => 'In Progress', 'completed' => 'Completed', 'verified' => 'Verified'], false),
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