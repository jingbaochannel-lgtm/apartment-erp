<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UtilityReading extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'utility_readings';

    protected $fillable = [
        'billing_month',
        'contract_id',
        'created_by',
        'deleted_by',
        'metadata',
        'new_reading',
        'old_reading',
        'price_per_unit',
        'reading_date',
        'reading_no',
        'room_id',
        'status',
        'total_fee',
        'updated_by',
        'usage_unit',
        'utility_meter_id',
    ];

    protected $casts = [
        'reading_date' => 'date',
        'old_reading' => 'decimal:3',
        'new_reading' => 'decimal:3',
        'usage_unit' => 'decimal:3',
        'price_per_unit' => 'decimal:4',
        'total_fee' => 'decimal:2',
        'metadata' => 'array',
    ];

    public function meter(): BelongsTo
    {
        return $this->belongsTo(UtilityMeter::class, 'utility_meter_id');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(RentalContract::class, 'contract_id');
    }
}
