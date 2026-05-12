<?php

namespace App\Http\Controllers\Admin;

use App\Models\StaffAttendance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Staff Attendance.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class StaffAttendanceController extends BaseCrudController
{
    protected string $modelClass = StaffAttendance::class;
    protected string $routeSlug = 'staff-attendances';
    protected ?string $permissionModule = 'staff_attendances';
    protected string $singular = 'Staff Attendance';
    protected string $plural = 'Staff Attendance';
    protected array $with = [];
    protected array $searchable = [];
    protected array $columns = [
        'id' => '#',
        'staff_id' => 'Staff',
        'attendance_date' => 'Date',
        'time_in' => 'In',
        'time_out' => 'Out',
        'attendance_status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::select('staff_id', 'Staff', static::options(\App\Models\Staff::class), true),
            \App\Support\CrudField::date('attendance_date', 'Date', false),
            \App\Support\CrudField::text('time_in', 'Time In', false),
            \App\Support\CrudField::text('time_out', 'Time Out', false),
            \App\Support\CrudField::number('late_minutes', 'Late (min)', false),
            \App\Support\CrudField::number('early_leave_minutes', 'Early Leave (min)', false),
            \App\Support\CrudField::select('attendance_status', 'Status', ['present' => 'Present', 'absent' => 'Absent', 'leave' => 'Leave', 'late' => 'Late', 'half_day' => 'Half Day'], false),
            \App\Support\CrudField::textarea('notes', 'Notes', false, 3),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'staff_id' => ['required', 'string', 'max:191'],
            'attendance_date' => ['nullable', 'date'],
            'time_in' => ['nullable', 'string', 'max:191'],
            'time_out' => ['nullable', 'string', 'max:191'],
            'late_minutes' => ['nullable', 'integer'],
            'early_leave_minutes' => ['nullable', 'integer'],
            'attendance_status' => ['nullable', 'string', 'max:191'],
            'notes' => ['nullable', 'string'],
        ];
    }
}