<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'purchase_orders';

    protected $fillable = [
        'approved_at',
        'approved_by',
        'created_by',
        'deleted_by',
        'expected_delivery_date',
        'metadata',
        'po_date',
        'po_no',
        'status',
        'supplier_id',
        'total_amount',
        'updated_by',
    ];

    protected $casts = [
        'po_date' => 'date',
        'expected_delivery_date' => 'date',
        'total_amount' => 'decimal:2',
        'approved_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class, 'purchase_order_id');
    }
}
