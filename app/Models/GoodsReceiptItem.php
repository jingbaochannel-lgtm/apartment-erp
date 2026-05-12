<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReceiptItem extends Model
{
    protected $table = 'goods_receipt_items';

    protected $fillable = [
        'damaged_quantity',
        'goods_receipt_id',
        'inventory_item_id',
        'received_quantity',
        'unit_price',
    ];

    protected $casts = [
        'received_quantity' => 'decimal:3',
        'damaged_quantity' => 'decimal:3',
        'unit_price' => 'decimal:2',
    ];
}
