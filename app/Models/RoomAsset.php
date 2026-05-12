<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomAsset extends Model
{
    protected $table = 'room_assets';

    protected $fillable = [
        'asset_id',
        'assigned_date',
        'condition_on_assign',
        'condition_on_remove',
        'removed_date',
        'room_id',
    ];

    protected $casts = [
        'assigned_date' => 'date',
        'removed_date' => 'date',
    ];
}
