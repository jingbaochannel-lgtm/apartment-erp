<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Models\Concerns\BelongsToApartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LegalDocument extends Model
{
    use SoftDeletes, Auditable, BelongsToApartment;

    protected $table = 'legal_documents';

    protected $fillable = [
        'apartment_profile_id',
        'created_by',
        'deleted_by',
        'document_code',
        'document_type',
        'expiry_date',
        'file_path',
        'issue_date',
        'license_or_reference_no',
        'metadata',
        'status',
        'title',
        'updated_by',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'metadata' => 'array',
    ];
}
