<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Models\PropertyOwner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApartmentProfile extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'apartment_profiles';

    protected $fillable = [
        'address',
        'apartment_code',
        'business_license_number',
        'created_by',
        'currency',
        'deleted_by',
        'email',
        'logo_path',
        'metadata',
        'name',
        'phone',
        'property_owner_id',
        'signature_path',
        'stamp_path',
        'status',
        'tax_identification_number',
        'timezone',
        'updated_by',
        'website',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function propertyOwner(): BelongsTo
    {
        return $this->belongsTo(PropertyOwner::class, 'property_owner_id');
    }

    public function buildings(): HasMany
    {
        return $this->hasMany(\App\Models\Building::class, 'apartment_profile_id');
    }

    public function departments(): HasMany
    {
        return $this->hasMany(\App\Models\Department::class, 'apartment_profile_id');
    }

    public function tenants(): HasMany
    {
        return $this->hasMany(\App\Models\Tenant::class, 'apartment_profile_id');
    }
}
