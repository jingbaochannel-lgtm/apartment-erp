<?php

namespace App\Http\Controllers\Admin;

use App\Models\Building;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Buildings.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class BuildingController extends BaseCrudController
{
    protected string $modelClass = Building::class;
    protected string $routeSlug = 'buildings';
    protected ?string $permissionModule = 'buildings';
    protected string $singular = 'Building';
    protected string $plural = 'Buildings';
    protected array $with = ['manager'];
    protected array $searchable = ['building_code', 'name', 'location'];
    protected array $columns = [
        'id' => '#',
        'building_code' => 'Code',
        'name' => 'Name',
        'location' => 'Location',
        'total_floors' => 'Floors',
        'total_rooms' => 'Rooms',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::select('manager_staff_id', 'Manager', static::options(\App\Models\Staff::class), false),
            \App\Support\CrudField::text('building_code', 'Code', true),
            \App\Support\CrudField::text('name', 'Name', true),
            \App\Support\CrudField::textarea('location', 'Location', false, 3),
            \App\Support\CrudField::number('total_floors', 'Total Floors', false),
            \App\Support\CrudField::number('total_rooms', 'Total Rooms', false),
            \App\Support\CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'manager_staff_id' => ['nullable', 'string', 'max:191'],
            'building_code' => ['required', 'string', 'max:191'],
            'name' => ['required', 'string', 'max:191'],
            'location' => ['nullable', 'string'],
            'total_floors' => ['nullable', 'integer'],
            'total_rooms' => ['nullable', 'integer'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}