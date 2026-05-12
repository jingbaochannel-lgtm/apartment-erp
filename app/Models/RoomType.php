<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Models\Concerns\BelongsToApartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomType extends Model
{
    use Auditable, BelongsToApartment, SoftDeletes;

    protected $table = 'room_types';

    protected $fillable = [
        'apartment_profile_id',
        'created_by',
        'default_capacity',
        'default_deposit_amount',
        'default_monthly_rent',
        'deleted_by',
        'description',
        'metadata',
        'name',
        'status',
        'type_code',
        'updated_by',
    ];

    protected $casts = [
        'default_monthly_rent' => 'decimal:2',
        'default_deposit_amount' => 'decimal:2',
        'metadata' => 'array',
    ];

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'room_type_facility', 'room_type_id', 'facility_id');
    }
}
