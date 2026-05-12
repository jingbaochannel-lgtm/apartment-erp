<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CapaAction extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'capa_actions';

    protected $fillable = [
        'capa_no',
        'complaint_id',
        'corrective_action',
        'created_by',
        'deleted_by',
        'due_date',
        'metadata',
        'preventive_action',
        'responsible_staff_id',
        'root_cause',
        'status',
        'updated_by',
        'verification_of_effectiveness',
        'verified_date',
    ];

    protected $casts = [
        'due_date' => 'date',
        'verified_date' => 'date',
        'metadata' => 'array',
    ];
}
