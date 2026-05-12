<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DebtReminder extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'debt_reminders';

    protected $fillable = [
        'amount_due',
        'created_by',
        'deleted_by',
        'delivery_status',
        'invoice_id',
        'message',
        'metadata',
        'overdue_days',
        'reminder_channel',
        'reminder_date',
        'reminder_no',
        'tenant_id',
        'updated_by',
    ];

    protected $casts = [
        'reminder_date' => 'date',
        'amount_due' => 'decimal:2',
        'metadata' => 'array',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
