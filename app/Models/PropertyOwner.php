<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyOwner extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'property_owners';

    protected $fillable = [
        'address',
        'bank_account_name',
        'bank_account_number',
        'bank_name',
        'created_by',
        'deleted_by',
        'email',
        'metadata',
        'name',
        'owner_code',
        'ownership_percentage',
        'phone',
        'status',
        'updated_by',
    ];

    protected $casts = [
        'ownership_percentage' => 'decimal:2',
        'metadata' => 'array',
    ];
}
