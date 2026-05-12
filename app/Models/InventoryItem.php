<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Models\InventoryCategory;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryItem extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'inventory_items';

    protected $fillable = [
        'created_by',
        'current_stock',
        'deleted_by',
        'inventory_category_id',
        'item_code',
        'item_name',
        'metadata',
        'minimum_stock',
        'purchase_price',
        'status',
        'supplier_id',
        'unit',
        'updated_by',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'current_stock' => 'decimal:3',
        'minimum_stock' => 'decimal:3',
        'metadata' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(InventoryCategory::class, 'inventory_category_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
