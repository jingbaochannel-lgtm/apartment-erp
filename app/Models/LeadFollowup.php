<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadFollowup extends Model
{
    protected $table = 'lead_followups';

    protected $fillable = [
        'followup_at',
        'followup_type',
        'lead_id',
        'next_action',
        'next_followup_at',
        'notes',
        'staff_id',
    ];

    protected $casts = [
        'followup_at' => 'datetime',
        'next_followup_at' => 'datetime',
    ];
}
