<?php

namespace App\Http\Controllers\Admin;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Staff.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class StaffController extends BaseCrudController
{
    protected string $modelClass = Staff::class;
    protected string $routeSlug = 'staff';
    protected ?string $permissionModule = 'staff';
    protected string $singular = 'Staff';
    protected string $plural = 'Staff';
    protected array $with = ['department'];
    protected array $searchable = ['staff_code', 'full_name', 'phone', 'email'];
    protected array $columns = [
        'id' => '#',
        'staff_code' => 'Code',
        'full_name' => 'Name',
        'department.name' => 'Department',
        'position' => 'Position',
        'phone' => 'Phone',
        'employment_status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::select('department_id', 'Department', static::options(\App\Models\Department::class), true),
            \App\Support\CrudField::text('staff_code', 'Code', true),
            \App\Support\CrudField::text('full_name', 'Full Name', true),
            \App\Support\CrudField::text('position', 'Position', false),
            \App\Support\CrudField::text('phone', 'Phone', false),
            \App\Support\CrudField::email('email', 'Email', false),
            \App\Support\CrudField::textarea('address', 'Address', false, 3),
            \App\Support\CrudField::date('hire_date', 'Hire Date', false),
            \App\Support\CrudField::decimal('basic_salary', 'Basic Salary', false),
            \App\Support\CrudField::select('employment_status', 'Status', ['active' => 'Active', 'on_leave' => 'On Leave', 'terminated' => 'Terminated', 'resigned' => 'Resigned'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'department_id' => ['required', 'string', 'max:191'],
            'staff_code' => ['required', 'string', 'max:191'],
            'full_name' => ['required', 'string', 'max:191'],
            'position' => ['nullable', 'string', 'max:191'],
            'phone' => ['nullable', 'string', 'max:191'],
            'email' => ['nullable', 'email', 'max:191'],
            'address' => ['nullable', 'string'],
            'hire_date' => ['nullable', 'date'],
            'basic_salary' => ['nullable', 'numeric'],
            'employment_status' => ['nullable', 'string', 'max:191'],
        ];
    }
}