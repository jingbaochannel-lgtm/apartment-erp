<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffDocument extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'staff_documents';

    protected $fillable = [
        'created_by',
        'deleted_by',
        'document_code',
        'document_type',
        'expiry_date',
        'file_path',
        'metadata',
        'staff_id',
        'title',
        'updated_by',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'metadata' => 'array',
    ];
}
