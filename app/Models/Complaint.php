<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'complaints';

    protected $fillable = [
        'complaint_no',
        'complaint_type',
        'created_by',
        'deleted_by',
        'description',
        'metadata',
        'photo_paths',
        'received_date',
        'resolved_date',
        'responsible_staff_id',
        'room_id',
        'status',
        'tenant_id',
        'updated_by',
    ];

    protected $casts = [
        'received_date' => 'date',
        'resolved_date' => 'date',
        'photo_paths' => 'array',
        'metadata' => 'array',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'responsible_staff_id');
    }
}
