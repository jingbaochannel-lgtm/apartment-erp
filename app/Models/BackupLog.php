<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BackupLog extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'backup_logs';

    protected $fillable = [
        'backup_no',
        'backup_type',
        'completed_at',
        'created_by',
        'deleted_by',
        'error_message',
        'file_path',
        'file_size_bytes',
        'metadata',
        'restore_tested_at',
        'started_at',
        'status',
        'storage_location',
        'updated_by',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'restore_tested_at' => 'datetime',
        'metadata' => 'array',
    ];
}
