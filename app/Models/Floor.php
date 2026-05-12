<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Floor extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'floors';

    protected $fillable = [
        'building_id',
        'created_by',
        'deleted_by',
        'floor_code',
        'floor_map_path',
        'floor_number',
        'metadata',
        'notes',
        'room_count',
        'status',
        'updated_by',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'floor_id');
    }
}
