<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UtilityType extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'utility_types';

    protected $fillable = [
        'billing_method',
        'created_by',
        'deleted_by',
        'metadata',
        'name',
        'status',
        'unit',
        'updated_by',
        'utility_code',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];
}
