<?php

namespace App\Http\Controllers\Admin;

use App\Models\UtilityRate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
            \App\Support\CrudField::select('utility_type_id', 'Utility Type', static::options(\App\Models\UtilityType::class), true),
            \App\Support\CrudField::decimal('price_per_unit', 'Price per Unit', false),
            \App\Support\CrudField::decimal('minimum_charge', 'Minimum Charge', false),
            \App\Support\CrudField::date('effective_from', 'Effective From', false),
            \App\Support\CrudField::date('effective_to', 'Effective To', false),
            \App\Support\CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
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