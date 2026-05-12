<?php

namespace App\Http\Controllers\Admin;

use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use App\Models\RoomType;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Rooms.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class RoomController extends BaseCrudController
{
    protected string $modelClass = Room::class;

    protected string $routeSlug = 'rooms';

    protected ?string $permissionModule = 'rooms';

    protected string $singular = 'Room';

    protected string $plural = 'Rooms';

    protected array $with = ['building', 'floor', 'roomType'];

    protected array $searchable = ['room_code', 'room_number'];

    protected array $columns = [
        'id' => '#',
        'room_code' => 'Code',
        'room_number' => 'Number',
        'building.name' => 'Building',
        'floor.floor_number' => 'Floor',
        'roomType.name' => 'Type',
        'monthly_rent' => 'Rent',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::select('building_id', 'Building', static::options(Building::class), true),
            CrudField::select('floor_id', 'Floor', static::options(Floor::class), true),
            CrudField::select('room_type_id', 'Room Type', static::options(RoomType::class), true),
            CrudField::text('room_code', 'Code', true),
            CrudField::text('room_number', 'Number', true),
            CrudField::decimal('size_sqm', 'Size (m²)', false),
            CrudField::number('capacity', 'Capacity', false),
            CrudField::decimal('monthly_rent', 'Monthly Rent', false),
            CrudField::decimal('deposit_amount', 'Deposit Amount', false),
            CrudField::textarea('description', 'Description', false, 3),
            CrudField::select('status', 'Status', ['available' => 'Available', 'occupied' => 'Occupied', 'reserved' => 'Reserved', 'maintenance' => 'Maintenance', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'building_id' => ['required', 'string', 'max:191'],
            'floor_id' => ['required', 'string', 'max:191'],
            'room_type_id' => ['required', 'string', 'max:191'],
            'room_code' => ['required', 'string', 'max:191'],
            'room_number' => ['required', 'string', 'max:191'],
            'size_sqm' => ['nullable', 'numeric'],
            'capacity' => ['nullable', 'integer'],
            'monthly_rent' => ['nullable', 'numeric'],
            'deposit_amount' => ['nullable', 'numeric'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
