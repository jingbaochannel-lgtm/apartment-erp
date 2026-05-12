<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Models\Concerns\BelongsToApartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenaltyRule extends Model
{
    use SoftDeletes, Auditable, BelongsToApartment;

    protected $table = 'penalty_rules';

    protected $fillable = [
        'apartment_profile_id',
        'created_by',
        'deleted_by',
        'grace_days',
        'maximum_penalty',
        'metadata',
        'name',
        'penalty_type',
        'rate_or_amount',
        'rule_code',
        'status',
        'updated_by',
    ];

    protected $casts = [
        'rate_or_amount' => 'decimal:4',
        'maximum_penalty' => 'decimal:2',
        'metadata' => 'array',
    ];
}
