<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Models\Concerns\BelongsToApartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentGateway extends Model
{
    use Auditable, BelongsToApartment, SoftDeletes;

    protected $table = 'payment_gateways';

    protected $fillable = [
        'apartment_profile_id',
        'configuration',
        'created_by',
        'deleted_by',
        'gateway_code',
        'gateway_name',
        'metadata',
        'provider',
        'sandbox_mode',
        'status',
        'updated_by',
    ];

    protected $casts = [
        'configuration' => 'array',
        'sandbox_mode' => 'boolean',
        'metadata' => 'array',
    ];
}
