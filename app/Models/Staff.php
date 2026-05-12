<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Models\Concerns\BelongsToApartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use Auditable, BelongsToApartment, SoftDeletes;

    protected $table = 'staff';

    protected $fillable = [
        'address',
        'apartment_profile_id',
        'basic_salary',
        'created_by',
        'deleted_by',
        'department_id',
        'email',
        'employment_status',
        'full_name',
        'hire_date',
        'metadata',
        'phone',
        'position',
        'staff_code',
        'updated_by',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'basic_salary' => 'decimal:2',
        'metadata' => 'array',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(StaffDocument::class, 'staff_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(StaffAttendance::class, 'staff_id');
    }

    public function payrolls(): HasMany
    {
        return $this->hasMany(Payroll::class, 'staff_id');
    }
}
