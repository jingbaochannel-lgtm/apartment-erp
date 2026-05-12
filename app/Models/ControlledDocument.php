<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ControlledDocument extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'controlled_documents';

    protected $fillable = [
        'approved_at',
        'approved_by',
        'created_by',
        'deleted_by',
        'document_code',
        'document_type',
        'effective_date',
        'file_path',
        'metadata',
        'prepared_by',
        'reviewed_by',
        'status',
        'title',
        'updated_by',
        'version_number',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'approved_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function revisions(): HasMany
    {
        return $this->hasMany(\App\Models\ControlledDocumentRevision::class, 'controlled_document_id');
    }
}
