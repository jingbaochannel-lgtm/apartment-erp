<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'leads';

    protected $fillable = [
        'appointment_date',
        'converted_tenant_id',
        'created_by',
        'deleted_by',
        'email',
        'interest_notes',
        'lead_no',
        'metadata',
        'name',
        'phone',
        'room_id',
        'source',
        'status',
        'updated_by',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'metadata' => 'array',
    ];

    public function followups(): HasMany
    {
        return $this->hasMany(LeadFollowup::class, 'lead_id');
    }
}
