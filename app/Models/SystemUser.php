<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SystemUser extends Authenticatable
{
    use Auditable, Notifiable, SoftDeletes;

    protected $table = 'system_users';

    protected $fillable = [
        'created_by',
        'deleted_by',
        'email',
        'failed_login_attempts',
        'last_login_at',
        'last_login_ip',
        'locked_until',
        'metadata',
        'name',
        'password',
        'phone',
        'staff_id',
        'status',
        'tenant_id',
        'two_factor_enabled',
        'two_factor_secret',
        'updated_by',
        'user_type',
        'username',
    ];

    protected $casts = [
        'two_factor_enabled' => 'boolean',
        'last_login_at' => 'datetime',
        'locked_until' => 'datetime',
        'password' => 'hashed',
        'metadata' => 'array',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(SystemRole::class, 'user_role', 'user_id', 'role_id');
    }

    public function directPermissions(): BelongsToMany
    {
        return $this->belongsToMany(SystemPermission::class, 'user_permission', 'user_id', 'permission_id');
    }
}
