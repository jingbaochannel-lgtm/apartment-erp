<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockMovement extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'stock_movements';

    protected $fillable = [
        'created_by',
        'deleted_by',
        'inventory_item_id',
        'metadata',
        'movement_date',
        'movement_no',
        'movement_type',
        'notes',
        'performed_by',
        'quantity',
        'reference_id',
        'reference_type',
        'total_cost',
        'unit_cost',
        'updated_by',
    ];

    protected $casts = [
        'movement_date' => 'date',
        'quantity' => 'decimal:3',
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'metadata' => 'array',
    ];
}
