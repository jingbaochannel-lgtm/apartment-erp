<?php

namespace App\Models;

use App\Models\Building;
use App\Models\Concerns\Auditable;
use App\Models\Floor;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'rooms';

    protected $fillable = [
        'building_id',
        'capacity',
        'created_by',
        'deleted_by',
        'deposit_amount',
        'description',
        'floor_id',
        'gallery_paths',
        'metadata',
        'monthly_rent',
        'room_code',
        'room_number',
        'room_type_id',
        'size_sqm',
        'status',
        'updated_by',
    ];

    protected $casts = [
        'size_sqm' => 'decimal:2',
        'monthly_rent' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'gallery_paths' => 'array',
        'metadata' => 'array',
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class, 'floor_id');
    }

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(\App\Models\RentalContract::class, 'room_id');
    }

    public function assets(): HasMany
    {
        return $this->hasMany(\App\Models\RoomAsset::class, 'room_id');
    }
}
