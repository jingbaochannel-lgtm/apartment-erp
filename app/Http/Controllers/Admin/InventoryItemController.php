<?php

namespace App\Http\Controllers\Admin;

use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use App\Models\Supplier;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Inventory Items.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class InventoryItemController extends BaseCrudController
{
    protected string $modelClass = InventoryItem::class;

    protected string $routeSlug = 'inventory-items';

    protected ?string $permissionModule = 'inventory_items';

    protected string $singular = 'Inventory Item';

    protected string $plural = 'Inventory Items';

    protected array $with = ['category', 'supplier'];

    protected array $searchable = ['item_code', 'item_name'];

    protected array $columns = [
        'id' => '#',
        'item_code' => 'Code',
        'item_name' => 'Name',
        'category.name' => 'Category',
        'supplier.supplier_name' => 'Supplier',
        'unit' => 'Unit',
        'current_stock' => 'Stock',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::select('inventory_category_id', 'Category', static::options(InventoryCategory::class), true),
            CrudField::select('supplier_id', 'Supplier', static::options(Supplier::class), false),
            CrudField::text('item_code', 'Code', true),
            CrudField::text('item_name', 'Name', true),
            CrudField::text('unit', 'Unit', false),
            CrudField::decimal('purchase_price', 'Purchase Price', false),
            CrudField::decimal('current_stock', 'Current Stock', false),
            CrudField::decimal('minimum_stock', 'Minimum Stock', false),
            CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'inventory_category_id' => ['required', 'string', 'max:191'],
            'supplier_id' => ['nullable', 'string', 'max:191'],
            'item_code' => ['required', 'string', 'max:191'],
            'item_name' => ['required', 'string', 'max:191'],
            'unit' => ['nullable', 'string', 'max:191'],
            'purchase_price' => ['nullable', 'numeric'],
            'current_stock' => ['nullable', 'numeric'],
            'minimum_stock' => ['nullable', 'numeric'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
