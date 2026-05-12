<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'feedback';

    protected $fillable = [
        'cleanliness_score',
        'comment',
        'created_by',
        'deleted_by',
        'feedback_date',
        'metadata',
        'overall_satisfaction_score',
        'rating',
        'room_id',
        'security_score',
        'service_quality_score',
        'status',
        'tenant_id',
        'updated_by',
    ];

    protected $casts = [
        'feedback_date' => 'date',
        'metadata' => 'array',
    ];
}
