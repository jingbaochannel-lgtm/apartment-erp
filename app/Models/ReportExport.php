<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportExport extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'report_exports';

    protected $fillable = [
        'completed_at',
        'created_by',
        'deleted_by',
        'export_no',
        'file_path',
        'filters',
        'format',
        'metadata',
        'report_type',
        'requested_at',
        'requested_by',
        'status',
        'updated_by',
    ];

    protected $casts = [
        'filters' => 'array',
        'requested_at' => 'datetime',
        'completed_at' => 'datetime',
        'metadata' => 'array',
    ];
}
