<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomTypeFacility extends Model
{
    protected $table = 'room_type_facility';

    protected $fillable = [
        'facility_id',
        'quantity',
        'room_type_id',
    ];
}
