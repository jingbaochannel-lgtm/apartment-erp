<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Models\Concerns\BelongsToApartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use SoftDeletes, Auditable, BelongsToApartment;

    protected $table = 'tenants';

    protected $fillable = [
        'address',
        'apartment_profile_id',
        'created_by',
        'date_of_birth',
        'deleted_by',
        'email',
        'full_name',
        'gender',
        'id_card_number',
        'metadata',
        'nationality',
        'occupation',
        'passport_number',
        'phone',
        'photo_path',
        'status',
        'tenant_code',
        'updated_by',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'metadata' => 'array',
    ];

    public function contacts(): HasMany
    {
        return $this->hasMany(\App\Models\TenantContact::class, 'tenant_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(\App\Models\TenantDocument::class, 'tenant_id');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(\App\Models\RentalContract::class, 'tenant_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(\App\Models\Invoice::class, 'tenant_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(\App\Models\Payment::class, 'tenant_id');
    }
}
