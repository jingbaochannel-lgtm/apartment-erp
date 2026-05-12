<?php

namespace App\Http\Controllers\Admin;

use App\Models\Building;
use App\Models\PreventiveMaintenanceSchedule;
use App\Models\Room;
use App\Models\Staff;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Preventive Maintenance.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class PreventiveMaintenanceScheduleController extends BaseCrudController
{
    protected string $modelClass = PreventiveMaintenanceSchedule::class;

    protected string $routeSlug = 'preventive-maintenance-schedules';

    protected ?string $permissionModule = 'preventive_maintenance_schedules';

    protected string $singular = 'Preventive Maintenance';

    protected string $plural = 'Preventive Maintenance';

    protected array $with = [];

    protected array $searchable = ['schedule_no', 'maintenance_type'];

    protected array $columns = [
        'id' => '#',
        'schedule_no' => 'No.',
        'maintenance_type' => 'Type',
        'scheduled_date' => 'Scheduled',
        'completed_date' => 'Completed',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::text('schedule_no', 'No.', true),
            CrudField::select('building_id', 'Building', static::options(Building::class), false),
            CrudField::select('room_id', 'Room', static::options(Room::class), false),
            CrudField::select('assigned_staff_id', 'Assigned Staff', static::options(Staff::class), false),
            CrudField::text('maintenance_type', 'Type', false),
            CrudField::date('scheduled_date', 'Scheduled Date', false),
            CrudField::date('completed_date', 'Completed Date', false),
            CrudField::textarea('checklist', 'Checklist', false, 4),
            CrudField::textarea('result_notes', 'Result Notes', false, 3),
            CrudField::select('status', 'Status', ['scheduled' => 'Scheduled', 'in_progress' => 'In Progress', 'completed' => 'Completed', 'cancelled' => 'Cancelled'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'schedule_no' => ['required', 'string', 'max:191'],
            'building_id' => ['nullable', 'string', 'max:191'],
            'room_id' => ['nullable', 'string', 'max:191'],
            'assigned_staff_id' => ['nullable', 'string', 'max:191'],
            'maintenance_type' => ['nullable', 'string', 'max:191'],
            'scheduled_date' => ['nullable', 'date'],
            'completed_date' => ['nullable', 'date'],
            'checklist' => ['nullable', 'string'],
            'result_notes' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
