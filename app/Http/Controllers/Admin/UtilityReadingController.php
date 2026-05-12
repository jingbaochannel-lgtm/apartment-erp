<?php

namespace App\Http\Controllers\Admin;

use App\Models\RentalContract;
use App\Models\Room;
use App\Models\UtilityMeter;
use App\Models\UtilityReading;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Utility Readings.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class UtilityReadingController extends BaseCrudController
{
    protected string $modelClass = UtilityReading::class;

    protected string $routeSlug = 'utility-readings';

    protected ?string $permissionModule = 'utility_readings';

    protected string $singular = 'Utility Reading';

    protected string $plural = 'Utility Readings';

    protected array $with = ['room', 'meter'];

    protected array $searchable = ['reading_no', 'billing_month'];

    protected array $columns = [
        'id' => '#',
        'reading_no' => 'No.',
        'room.room_code' => 'Room',
        'billing_month' => 'Month',
        'old_reading' => 'Old',
        'new_reading' => 'New',
        'usage_unit' => 'Usage',
        'total_fee' => 'Total Fee',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::text('reading_no', 'No.', true),
            CrudField::select('utility_meter_id', 'Meter', static::options(UtilityMeter::class), true),
            CrudField::select('room_id', 'Room', static::options(Room::class), false),
            CrudField::select('contract_id', 'Contract', static::options(RentalContract::class), false),
            CrudField::date('reading_date', 'Reading Date', true),
            CrudField::text('billing_month', 'Billing Month (YYYY-MM)', false),
            CrudField::decimal('old_reading', 'Old Reading', false),
            CrudField::decimal('new_reading', 'New Reading', false),
            CrudField::decimal('usage_unit', 'Usage Unit', false),
            CrudField::decimal('price_per_unit', 'Price/Unit', false),
            CrudField::decimal('total_fee', 'Total Fee', false),
            CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'reading_no' => ['required', 'string', 'max:191'],
            'utility_meter_id' => ['required', 'string', 'max:191'],
            'room_id' => ['nullable', 'string', 'max:191'],
            'contract_id' => ['nullable', 'string', 'max:191'],
            'reading_date' => ['required', 'date'],
            'billing_month' => ['nullable', 'string', 'max:191'],
            'old_reading' => ['nullable', 'numeric'],
            'new_reading' => ['nullable', 'numeric'],
            'usage_unit' => ['nullable', 'numeric'],
            'price_per_unit' => ['nullable', 'numeric'],
            'total_fee' => ['nullable', 'numeric'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
