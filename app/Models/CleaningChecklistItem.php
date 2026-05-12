<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CleaningChecklistItem extends Model
{
    protected $table = 'cleaning_checklist_items';

    protected $fillable = [
        'cleaning_task_id',
        'is_completed',
        'item_name',
        'notes',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
    ];
}
