<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CleaningTask extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'cleaning_tasks';

    protected $fillable = [
        'area_type',
        'assigned_staff_id',
        'building_id',
        'cleaning_date',
        'created_by',
        'deleted_by',
        'metadata',
        'photo_paths',
        'public_area',
        'remark',
        'room_id',
        'status',
        'task_no',
        'updated_by',
    ];

    protected $casts = [
        'cleaning_date' => 'date',
        'photo_paths' => 'array',
        'metadata' => 'array',
    ];

    public function checklistItems(): HasMany
    {
        return $this->hasMany(\App\Models\CleaningChecklistItem::class, 'cleaning_task_id');
    }
}
