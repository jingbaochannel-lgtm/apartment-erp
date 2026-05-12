<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreventiveMaintenanceSchedule extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'preventive_maintenance_schedules';

    protected $fillable = [
        'assigned_staff_id',
        'building_id',
        'checklist',
        'completed_date',
        'created_by',
        'deleted_by',
        'maintenance_type',
        'metadata',
        'result_notes',
        'room_id',
        'schedule_no',
        'scheduled_date',
        'status',
        'updated_by',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'completed_date' => 'date',
        'metadata' => 'array',
    ];
}
