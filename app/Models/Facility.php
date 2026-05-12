<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facility extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'facilities';

    protected $fillable = [
        'category',
        'created_by',
        'deleted_by',
        'description',
        'facility_code',
        'metadata',
        'name',
        'status',
        'updated_by',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];
}
