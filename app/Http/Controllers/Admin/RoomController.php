<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
            \App\Support\CrudField::select('building_id', 'Building', static::options(\App\Models\Building::class), true),
            \App\Support\CrudField::select('floor_id', 'Floor', static::options(\App\Models\Floor::class), true),
            \App\Support\CrudField::select('room_type_id', 'Room Type', static::options(\App\Models\RoomType::class), true),
            \App\Support\CrudField::text('room_code', 'Code', true),
            \App\Support\CrudField::text('room_number', 'Number', true),
            \App\Support\CrudField::decimal('size_sqm', 'Size (m²)', false),
            \App\Support\CrudField::number('capacity', 'Capacity', false),
            \App\Support\CrudField::decimal('monthly_rent', 'Monthly Rent', false),
            \App\Support\CrudField::decimal('deposit_amount', 'Deposit Amount', false),
            \App\Support\CrudField::textarea('description', 'Description', false, 3),
            \App\Support\CrudField::select('status', 'Status', ['available' => 'Available', 'occupied' => 'Occupied', 'reserved' => 'Reserved', 'maintenance' => 'Maintenance', 'inactive' => 'Inactive'], false),
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