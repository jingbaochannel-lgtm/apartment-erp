<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SystemPermission extends Model
{
    protected $table = 'system_permissions';

    protected $fillable = [
        'action',
        'description',
        'module',
        'name',
        'permission_code',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\SystemRole::class, 'role_permission', 'permission_id', 'role_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\SystemUser::class, 'user_permission', 'permission_id', 'user_id');
    }
}
