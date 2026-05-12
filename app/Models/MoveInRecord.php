<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoveInRecord extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'move_in_records';

    protected $fillable = [
        'contract_id',
        'created_by',
        'deleted_by',
        'electric_meter_reading',
        'facility_condition',
        'metadata',
        'move_in_date',
        'move_in_no',
        'photo_paths',
        'room_condition',
        'room_id',
        'status',
        'tenant_id',
        'tenant_signature_path',
        'updated_by',
        'water_meter_reading',
    ];

    protected $casts = [
        'move_in_date' => 'date',
        'water_meter_reading' => 'decimal:3',
        'electric_meter_reading' => 'decimal:3',
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
