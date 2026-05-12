<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Models\Room;
use App\Models\UtilityType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UtilityMeter extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'utility_meters';

    protected $fillable = [
        'created_by',
        'deleted_by',
        'initial_reading',
        'installed_date',
        'metadata',
        'meter_no',
        'room_id',
        'status',
        'updated_by',
        'utility_type_id',
    ];

    protected $casts = [
        'initial_reading' => 'decimal:3',
        'installed_date' => 'date',
        'metadata' => 'array',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function utilityType(): BelongsTo
    {
        return $this->belongsTo(UtilityType::class, 'utility_type_id');
    }
}
