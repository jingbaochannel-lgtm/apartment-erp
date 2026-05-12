<?php

namespace App\Http\Controllers\Admin;

use App\Models\Floor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Floors.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class FloorController extends BaseCrudController
{
    protected string $modelClass = Floor::class;
    protected string $routeSlug = 'floors';
    protected ?string $permissionModule = 'floors';
    protected string $singular = 'Floor';
    protected string $plural = 'Floors';
    protected array $with = ['building'];
    protected array $searchable = ['floor_code'];
    protected array $columns = [
        'id' => '#',
        'building.name' => 'Building',
        'floor_code' => 'Code',
        'floor_number' => 'Floor #',
        'room_count' => 'Rooms',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::select('building_id', 'Building', static::options(\App\Models\Building::class), true),
            \App\Support\CrudField::text('floor_code', 'Code', true),
            \App\Support\CrudField::number('floor_number', 'Floor Number', true),
            \App\Support\CrudField::number('room_count', 'Rooms', false),
            \App\Support\CrudField::text('floor_map_path', 'Map Path', false),
            \App\Support\CrudField::textarea('notes', 'Notes', false, 3),
            \App\Support\CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'building_id' => ['required', 'string', 'max:191'],
            'floor_code' => ['required', 'string', 'max:191'],
            'floor_number' => ['required', 'integer'],
            'room_count' => ['nullable', 'integer'],
            'floor_map_path' => ['nullable', 'string', 'max:191'],
            'notes' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}