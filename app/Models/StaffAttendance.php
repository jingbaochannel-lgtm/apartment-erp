<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffAttendance extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'staff_attendances';

    protected $fillable = [
        'attendance_date',
        'attendance_status',
        'created_by',
        'deleted_by',
        'early_leave_minutes',
        'late_minutes',
        'metadata',
        'notes',
        'staff_id',
        'time_in',
        'time_out',
        'updated_by',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'metadata' => 'array',
    ];
}
