<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Models\Concerns\BelongsToApartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use Auditable, BelongsToApartment, SoftDeletes;

    protected $table = 'departments';

    protected $fillable = [
        'apartment_profile_id',
        'created_by',
        'deleted_by',
        'department_code',
        'description',
        'metadata',
        'name',
        'status',
        'updated_by',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function staff(): HasMany
    {
        return $this->hasMany(Staff::class, 'department_id');
    }
}
