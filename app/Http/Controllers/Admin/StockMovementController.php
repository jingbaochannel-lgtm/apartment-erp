<?php

namespace App\Http\Controllers\Admin;

use App\Models\InventoryItem;
use App\Models\StockMovement;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Stock Movements.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class StockMovementController extends BaseCrudController
{
    protected string $modelClass = StockMovement::class;

    protected string $routeSlug = 'stock-movements';

    protected ?string $permissionModule = 'stock_movements';

    protected string $singular = 'Stock Movement';

    protected string $plural = 'Stock Movements';

    protected array $with = [];

    protected array $searchable = ['movement_no'];

    protected array $columns = [
        'id' => '#',
        'movement_no' => 'No.',
        'movement_type' => 'Type',
        'quantity' => 'Qty',
        'movement_date' => 'Date',
    ];

    protected function fields(): array
    {
        return [
            CrudField::text('movement_no', 'No.', true),
            CrudField::select('inventory_item_id', 'Item', static::options(InventoryItem::class), true),
            CrudField::select('movement_type', 'Type', ['in' => 'In', 'out' => 'Out', 'adjustment' => 'Adjustment', 'transfer' => 'Transfer'], false),
            CrudField::decimal('quantity', 'Quantity', false),
            CrudField::decimal('unit_cost', 'Unit Cost', false),
            CrudField::decimal('total_cost', 'Total Cost', false),
            CrudField::text('reference_type', 'Reference Type', false),
            CrudField::number('reference_id', 'Reference ID', false),
            CrudField::date('movement_date', 'Date', false),
            CrudField::text('performed_by', 'Performed By', false),
            CrudField::textarea('notes', 'Notes', false, 3),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'movement_no' => ['required', 'string', 'max:191'],
            'inventory_item_id' => ['required', 'string', 'max:191'],
            'movement_type' => ['nullable', 'string', 'max:191'],
            'quantity' => ['nullable', 'numeric'],
            'unit_cost' => ['nullable', 'numeric'],
            'total_cost' => ['nullable', 'numeric'],
            'reference_type' => ['nullable', 'string', 'max:191'],
            'reference_id' => ['nullable', 'integer'],
            'movement_date' => ['nullable', 'date'],
            'performed_by' => ['nullable', 'string', 'max:191'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
