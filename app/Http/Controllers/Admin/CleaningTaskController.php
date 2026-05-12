<?php

namespace App\Http\Controllers\Admin;

use App\Models\CleaningTask;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Cleaning Tasks.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class CleaningTaskController extends BaseCrudController
{
    protected string $modelClass = CleaningTask::class;
    protected string $routeSlug = 'cleaning-tasks';
    protected ?string $permissionModule = 'cleaning_tasks';
    protected string $singular = 'Cleaning Task';
    protected string $plural = 'Cleaning Tasks';
    protected array $with = [];
    protected array $searchable = ['task_no', 'area_type'];
    protected array $columns = [
        'id' => '#',
        'task_no' => 'No.',
        'area_type' => 'Area',
        'cleaning_date' => 'Date',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('task_no', 'No.', true),
            \App\Support\CrudField::select('room_id', 'Room', static::options(\App\Models\Room::class), false),
            \App\Support\CrudField::select('building_id', 'Building', static::options(\App\Models\Building::class), false),
            \App\Support\CrudField::select('assigned_staff_id', 'Assigned Staff', static::options(\App\Models\Staff::class), false),
            \App\Support\CrudField::select('area_type', 'Area Type', ['room' => 'Room', 'common' => 'Common Area', 'building' => 'Whole Building'], false),
            \App\Support\CrudField::text('public_area', 'Public Area', false),
            \App\Support\CrudField::date('cleaning_date', 'Cleaning Date', false),
            \App\Support\CrudField::textarea('remark', 'Remark', false, 3),
            \App\Support\CrudField::select('status', 'Status', ['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'task_no' => ['required', 'string', 'max:191'],
            'room_id' => ['nullable', 'string', 'max:191'],
            'building_id' => ['nullable', 'string', 'max:191'],
            'assigned_staff_id' => ['nullable', 'string', 'max:191'],
            'area_type' => ['nullable', 'string', 'max:191'],
            'public_area' => ['nullable', 'string', 'max:191'],
            'cleaning_date' => ['nullable', 'date'],
            'remark' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}