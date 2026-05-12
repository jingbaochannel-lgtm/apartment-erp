<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Departments.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class DepartmentController extends BaseCrudController
{
    protected string $modelClass = Department::class;

    protected string $routeSlug = 'departments';

    protected ?string $permissionModule = 'departments';

    protected string $singular = 'Department';

    protected string $plural = 'Departments';

    protected array $with = [];

    protected array $searchable = ['department_code', 'name'];

    protected array $columns = [
        'id' => '#',
        'department_code' => 'Code',
        'name' => 'Name',
        'description' => 'Description',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::text('department_code', 'Code', true),
            CrudField::text('name', 'Name', true),
            CrudField::textarea('description', 'Description', false, 3),
            CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'department_code' => ['required', 'string', 'max:191'],
            'name' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
