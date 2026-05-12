<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Models\Concerns\BelongsToApartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use Auditable, BelongsToApartment, SoftDeletes;

    protected $table = 'buildings';

    protected $fillable = [
        'apartment_profile_id',
        'building_code',
        'created_by',
        'deleted_by',
        'location',
        'manager_staff_id',
        'metadata',
        'name',
        'status',
        'total_floors',
        'total_rooms',
        'updated_by',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'manager_staff_id');
    }

    public function floors(): HasMany
    {
        return $this->hasMany(Floor::class, 'building_id');
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'building_id');
    }
}
