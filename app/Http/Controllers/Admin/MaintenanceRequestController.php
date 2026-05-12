<?php

namespace App\Http\Controllers\Admin;

use App\Models\MaintenanceRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Maintenance Requests.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class MaintenanceRequestController extends BaseCrudController
{
    protected string $modelClass = MaintenanceRequest::class;
    protected string $routeSlug = 'maintenance-requests';
    protected ?string $permissionModule = 'maintenance_requests';
    protected string $singular = 'Maintenance Request';
    protected string $plural = 'Maintenance Requests';
    protected array $with = ['room', 'tenant', 'assignedStaff'];
    protected array $searchable = ['request_no', 'problem_type'];
    protected array $columns = [
        'id' => '#',
        'request_no' => 'No.',
        'room.room_code' => 'Room',
        'tenant.full_name' => 'Tenant',
        'problem_type' => 'Problem',
        'priority' => 'Priority',
        'total_cost' => 'Cost',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('request_no', 'No.', true),
            \App\Support\CrudField::select('room_id', 'Room', static::options(\App\Models\Room::class), true),
            \App\Support\CrudField::select('tenant_id', 'Tenant', static::options(\App\Models\Tenant::class), false),
            \App\Support\CrudField::select('assigned_staff_id', 'Assigned Staff', static::options(\App\Models\Staff::class), false),
            \App\Support\CrudField::text('problem_type', 'Problem Type', false),
            \App\Support\CrudField::textarea('description', 'Description', false, 3),
            \App\Support\CrudField::select('priority', 'Priority', ['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'urgent' => 'Urgent'], false),
            \App\Support\CrudField::decimal('material_cost', 'Material Cost', false),
            \App\Support\CrudField::decimal('labor_cost', 'Labor Cost', false),
            \App\Support\CrudField::decimal('service_cost', 'Service Cost', false),
            \App\Support\CrudField::decimal('other_cost', 'Other Cost', false),
            \App\Support\CrudField::decimal('total_cost', 'Total Cost', false),
            \App\Support\CrudField::datetime('requested_at', 'Requested At', false),
            \App\Support\CrudField::datetime('completed_at', 'Completed At', false),
            \App\Support\CrudField::select('status', 'Status', ['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed', 'cancelled' => 'Cancelled'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'request_no' => ['required', 'string', 'max:191'],
            'room_id' => ['required', 'string', 'max:191'],
            'tenant_id' => ['nullable', 'string', 'max:191'],
            'assigned_staff_id' => ['nullable', 'string', 'max:191'],
            'problem_type' => ['nullable', 'string', 'max:191'],
            'description' => ['nullable', 'string'],
            'priority' => ['nullable', 'string', 'max:191'],
            'material_cost' => ['nullable', 'numeric'],
            'labor_cost' => ['nullable', 'numeric'],
            'service_cost' => ['nullable', 'numeric'],
            'other_cost' => ['nullable', 'numeric'],
            'total_cost' => ['nullable', 'numeric'],
            'requested_at' => ['nullable', 'date'],
            'completed_at' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}