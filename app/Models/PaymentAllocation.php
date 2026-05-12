<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentAllocation extends Model
{
    protected $table = 'payment_allocations';

    protected $fillable = [
        'allocated_amount',
        'invoice_id',
        'payment_id',
    ];

    protected $casts = [
        'allocated_amount' => 'decimal:2',
    ];
}
