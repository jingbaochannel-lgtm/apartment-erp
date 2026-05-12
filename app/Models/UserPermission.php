<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $table = 'user_permission';

    protected $fillable = [
        'allowed',
        'permission_id',
        'user_id',
    ];

    protected $casts = [
        'allowed' => 'boolean',
    ];
}
