<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'assets';

    protected $fillable = [
        'asset_code',
        'asset_name',
        'condition',
        'created_by',
        'deleted_by',
        'depreciation_rate',
        'inventory_item_id',
        'metadata',
        'purchase_date',
        'purchase_price',
        'room_id',
        'status',
        'updated_by',
        'warranty_expiry_date',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'purchase_price' => 'decimal:2',
        'warranty_expiry_date' => 'date',
        'depreciation_rate' => 'decimal:4',
        'metadata' => 'array',
    ];
}
