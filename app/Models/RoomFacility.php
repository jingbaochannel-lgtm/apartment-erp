<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomFacility extends Model
{
    protected $table = 'room_facility';

    protected $fillable = [
        'condition',
        'facility_id',
        'notes',
        'quantity',
        'room_id',
    ];
}
