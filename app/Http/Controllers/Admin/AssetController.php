<?php

namespace App\Http\Controllers\Admin;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Assets.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class AssetController extends BaseCrudController
{
    protected string $modelClass = Asset::class;
    protected string $routeSlug = 'assets';
    protected ?string $permissionModule = 'assets';
    protected string $singular = 'Asset';
    protected string $plural = 'Assets';
    protected array $with = [];
    protected array $searchable = ['asset_code', 'asset_name'];
    protected array $columns = [
        'id' => '#',
        'asset_code' => 'Code',
        'asset_name' => 'Name',
        'purchase_date' => 'Purchased',
        'purchase_price' => 'Price',
        'condition' => 'Condition',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('asset_code', 'Code', true),
            \App\Support\CrudField::text('asset_name', 'Name', true),
            \App\Support\CrudField::select('room_id', 'Room', static::options(\App\Models\Room::class), false),
            \App\Support\CrudField::select('inventory_item_id', 'Item', static::options(\App\Models\InventoryItem::class), false),
            \App\Support\CrudField::date('purchase_date', 'Purchase Date', false),
            \App\Support\CrudField::decimal('purchase_price', 'Purchase Price', false),
            \App\Support\CrudField::select('condition', 'Condition', ['new' => 'New', 'good' => 'Good', 'fair' => 'Fair', 'damaged' => 'Damaged'], false),
            \App\Support\CrudField::date('warranty_expiry_date', 'Warranty Expiry', false),
            \App\Support\CrudField::decimal('depreciation_rate', 'Depreciation Rate', false),
            \App\Support\CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'asset_code' => ['required', 'string', 'max:191'],
            'asset_name' => ['required', 'string', 'max:191'],
            'room_id' => ['nullable', 'string', 'max:191'],
            'inventory_item_id' => ['nullable', 'string', 'max:191'],
            'purchase_date' => ['nullable', 'date'],
            'purchase_price' => ['nullable', 'numeric'],
            'condition' => ['nullable', 'string', 'max:191'],
            'warranty_expiry_date' => ['nullable', 'date'],
            'depreciation_rate' => ['nullable', 'numeric'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}