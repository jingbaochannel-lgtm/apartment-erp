<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantContact extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'tenant_contacts';

    protected $fillable = [
        'address',
        'contact_type',
        'created_by',
        'deleted_by',
        'email',
        'metadata',
        'name',
        'phone',
        'relationship',
        'tenant_id',
        'updated_by',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
