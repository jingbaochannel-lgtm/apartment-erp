<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    protected $table = 'purchase_order_items';

    protected $fillable = [
        'inventory_item_id',
        'price',
        'purchase_order_id',
        'quantity',
        'total_amount',
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'price' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];
}
