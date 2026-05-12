<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControlledDocumentRevision extends Model
{
    protected $table = 'controlled_document_revisions';

    protected $fillable = [
        'controlled_document_id',
        'file_path',
        'revised_at',
        'revised_by',
        'revision_summary',
        'version_number',
    ];

    protected $casts = [
        'revised_at' => 'datetime',
    ];
}
