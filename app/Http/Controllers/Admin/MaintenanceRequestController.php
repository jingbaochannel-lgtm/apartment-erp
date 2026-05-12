<?php

namespace App\Http\Controllers\Admin;

use App\Models\MaintenanceRequest;
use App\Models\Room;
use App\Models\Staff;
use App\Models\Tenant;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

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
            CrudField::text('request_no', 'No.', true),
            CrudField::select('room_id', 'Room', static::options(Room::class), true),
            CrudField::select('tenant_id', 'Tenant', static::options(Tenant::class), false),
            CrudField::select('assigned_staff_id', 'Assigned Staff', static::options(Staff::class), false),
            CrudField::text('problem_type', 'Problem Type', false),
            CrudField::textarea('description', 'Description', false, 3),
            CrudField::select('priority', 'Priority', ['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'urgent' => 'Urgent'], false),
            CrudField::decimal('material_cost', 'Material Cost', false),
            CrudField::decimal('labor_cost', 'Labor Cost', false),
            CrudField::decimal('service_cost', 'Service Cost', false),
            CrudField::decimal('other_cost', 'Other Cost', false),
            CrudField::decimal('total_cost', 'Total Cost', false),
            CrudField::datetime('requested_at', 'Requested At', false),
            CrudField::datetime('completed_at', 'Completed At', false),
            CrudField::select('status', 'Status', ['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed', 'cancelled' => 'Cancelled'], false),
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
