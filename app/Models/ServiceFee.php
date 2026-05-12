<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Models\Concerns\BelongsToApartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceFee extends Model
{
    use Auditable, BelongsToApartment, SoftDeletes;

    protected $table = 'service_fees';

    protected $fillable = [
        'amount',
        'apartment_profile_id',
        'created_by',
        'deleted_by',
        'fee_type',
        'metadata',
        'name',
        'service_code',
        'status',
        'updated_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
    ];
}
