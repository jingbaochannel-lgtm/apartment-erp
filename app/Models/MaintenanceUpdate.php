<?php

namespace App\Models;

use App\Models\MaintenanceRequest;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceUpdate extends Model
{
    protected $table = 'maintenance_updates';

    protected $fillable = [
        'maintenance_request_id',
        'notes',
        'photo_paths',
        'status',
        'updated_by_staff_id',
    ];

    protected $casts = [
        'photo_paths' => 'array',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(MaintenanceRequest::class, 'maintenance_request_id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'updated_by_staff_id');
    }
}
