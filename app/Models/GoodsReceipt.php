<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsReceipt extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'goods_receipts';

    protected $fillable = [
        'created_by',
        'deleted_by',
        'grn_no',
        'metadata',
        'notes',
        'purchase_order_id',
        'received_by',
        'received_date',
        'status',
        'updated_by',
    ];

    protected $casts = [
        'received_date' => 'date',
        'metadata' => 'array',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(\App\Models\GoodsReceiptItem::class, 'goods_receipt_id');
    }
}
