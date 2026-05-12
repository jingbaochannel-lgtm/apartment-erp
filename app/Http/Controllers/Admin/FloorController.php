<?php

namespace App\Http\Controllers\Admin;

use App\Models\Building;
use App\Models\Floor;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

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
            CrudField::select('building_id', 'Building', static::options(Building::class), true),
            CrudField::text('floor_code', 'Code', true),
            CrudField::number('floor_number', 'Floor Number', true),
            CrudField::number('room_count', 'Rooms', false),
            CrudField::text('floor_map_path', 'Map Path', false),
            CrudField::textarea('notes', 'Notes', false, 3),
            CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
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
