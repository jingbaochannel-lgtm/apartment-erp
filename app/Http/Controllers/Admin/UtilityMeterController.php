<?php

namespace App\Http\Controllers\Admin;

use App\Models\UtilityMeter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Utility Meters.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class UtilityMeterController extends BaseCrudController
{
    protected string $modelClass = UtilityMeter::class;
    protected string $routeSlug = 'utility-meters';
    protected ?string $permissionModule = 'utility_meters';
    protected string $singular = 'Utility Meter';
    protected string $plural = 'Utility Meters';
    protected array $with = ['room', 'utilityType'];
    protected array $searchable = ['meter_no'];
    protected array $columns = [
        'id' => '#',
        'meter_no' => 'Meter No.',
        'room.room_code' => 'Room',
        'utilityType.name' => 'Utility',
        'initial_reading' => 'Initial',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::select('room_id', 'Room', static::options(\App\Models\Room::class), true),
            \App\Support\CrudField::select('utility_type_id', 'Utility Type', static::options(\App\Models\UtilityType::class), true),
            \App\Support\CrudField::text('meter_no', 'Meter No.', true),
            \App\Support\CrudField::decimal('initial_reading', 'Initial Reading', false),
            \App\Support\CrudField::date('installed_date', 'Installed', false),
            \App\Support\CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'room_id' => ['required', 'string', 'max:191'],
            'utility_type_id' => ['required', 'string', 'max:191'],
            'meter_no' => ['required', 'string', 'max:191'],
            'initial_reading' => ['nullable', 'numeric'],
            'installed_date' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}