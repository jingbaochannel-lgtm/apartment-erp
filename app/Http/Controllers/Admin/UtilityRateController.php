<?php

namespace App\Http\Controllers\Admin;

use App\Models\UtilityRate;
use App\Models\UtilityType;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Utility Rates.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class UtilityRateController extends BaseCrudController
{
    protected string $modelClass = UtilityRate::class;

    protected string $routeSlug = 'utility-rates';

    protected ?string $permissionModule = 'utility_rates';

    protected string $singular = 'Utility Rate';

    protected string $plural = 'Utility Rates';

    protected array $with = ['utilityType'];

    protected array $searchable = [];

    protected array $columns = [
        'id' => '#',
        'utilityType.name' => 'Utility',
        'price_per_unit' => 'Price/Unit',
        'minimum_charge' => 'Min Charge',
        'effective_from' => 'From',
        'effective_to' => 'To',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::select('utility_type_id', 'Utility Type', static::options(UtilityType::class), true),
            CrudField::decimal('price_per_unit', 'Price per Unit', false),
            CrudField::decimal('minimum_charge', 'Minimum Charge', false),
            CrudField::date('effective_from', 'Effective From', false),
            CrudField::date('effective_to', 'Effective To', false),
            CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'utility_type_id' => ['required', 'string', 'max:191'],
            'price_per_unit' => ['nullable', 'numeric'],
            'minimum_charge' => ['nullable', 'numeric'],
            'effective_from' => ['nullable', 'date'],
            'effective_to' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
