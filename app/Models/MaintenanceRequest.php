<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Models\Room;
use App\Models\Staff;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceRequest extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'maintenance_requests';

    protected $fillable = [
        'assigned_staff_id',
        'completed_at',
        'created_by',
        'deleted_by',
        'description',
        'labor_cost',
        'material_cost',
        'metadata',
        'other_cost',
        'photo_paths',
        'priority',
        'problem_type',
        'request_no',
        'requested_at',
        'room_id',
        'service_cost',
        'status',
        'tenant_id',
        'total_cost',
        'updated_by',
    ];

    protected $casts = [
        'photo_paths' => 'array',
        'material_cost' => 'decimal:2',
        'labor_cost' => 'decimal:2',
        'service_cost' => 'decimal:2',
        'other_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'requested_at' => 'datetime',
        'completed_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function assignedStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'assigned_staff_id');
    }

    public function updates(): HasMany
    {
        return $this->hasMany(\App\Models\MaintenanceUpdate::class, 'maintenance_request_id');
    }
}
