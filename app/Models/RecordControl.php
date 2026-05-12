<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecordControl extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'record_controls';

    protected $fillable = [
        'created_by',
        'deleted_by',
        'disposal_due_date',
        'disposal_method',
        'metadata',
        'record_code',
        'record_type',
        'responsible_person_id',
        'retention_period',
        'status',
        'storage_location',
        'updated_by',
    ];

    protected $casts = [
        'disposal_due_date' => 'date',
        'metadata' => 'array',
    ];
}
