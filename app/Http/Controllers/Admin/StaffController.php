<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Models\Staff;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

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
            CrudField::select('department_id', 'Department', static::options(Department::class), true),
            CrudField::text('staff_code', 'Code', true),
            CrudField::text('full_name', 'Full Name', true),
            CrudField::text('position', 'Position', false),
            CrudField::text('phone', 'Phone', false),
            CrudField::email('email', 'Email', false),
            CrudField::textarea('address', 'Address', false, 3),
            CrudField::date('hire_date', 'Hire Date', false),
            CrudField::decimal('basic_salary', 'Basic Salary', false),
            CrudField::select('employment_status', 'Status', ['active' => 'Active', 'on_leave' => 'On Leave', 'terminated' => 'Terminated', 'resigned' => 'Resigned'], false),
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
