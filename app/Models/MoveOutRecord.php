<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoveOutRecord extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'move_out_records';

    protected $fillable = [
        'contract_id',
        'created_by',
        'damage_deduction',
        'damaged_items',
        'deleted_by',
        'deposit_refund',
        'final_electric_meter_reading',
        'final_water_meter_reading',
        'metadata',
        'move_out_date',
        'move_out_no',
        'outstanding_balance',
        'photo_paths',
        'room_condition',
        'room_id',
        'status',
        'tenant_id',
        'tenant_signature_path',
        'updated_by',
    ];

    protected $casts = [
        'move_out_date' => 'date',
        'final_water_meter_reading' => 'decimal:3',
        'final_electric_meter_reading' => 'decimal:3',
        'outstanding_balance' => 'decimal:2',
        'damage_deduction' => 'decimal:2',
        'deposit_refund' => 'decimal:2',
        'photo_paths' => 'array',
        'metadata' => 'array',
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(RentalContract::class, 'contract_id');
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
