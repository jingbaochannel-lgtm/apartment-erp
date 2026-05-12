<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantDocument extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'tenant_documents';

    protected $fillable = [
        'created_by',
        'deleted_by',
        'document_code',
        'document_type',
        'expiry_date',
        'file_path',
        'is_verified',
        'issue_date',
        'metadata',
        'tenant_id',
        'title',
        'updated_by',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
