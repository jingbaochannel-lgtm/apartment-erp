<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomServiceFee extends Model
{
    protected $table = 'room_service_fees';

    protected $fillable = [
        'amount',
        'effective_from',
        'effective_to',
        'room_id',
        'service_fee_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'effective_from' => 'date',
        'effective_to' => 'date',
    ];
}
