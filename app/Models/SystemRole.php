<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemRole extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'system_roles';

    protected $fillable = [
        'created_by',
        'deleted_by',
        'description',
        'is_system',
        'metadata',
        'name',
        'role_code',
        'status',
        'updated_by',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'metadata' => 'array',
    ];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(SystemPermission::class, 'role_permission', 'role_id', 'permission_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(SystemUser::class, 'user_role', 'role_id', 'user_id');
    }
}
