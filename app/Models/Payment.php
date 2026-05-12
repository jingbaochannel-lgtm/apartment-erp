<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'payments';

    protected $fillable = [
        'amount_paid',
        'created_by',
        'deleted_by',
        'invoice_id',
        'metadata',
        'notes',
        'payment_date',
        'payment_method',
        'payment_no',
        'slip_path',
        'status',
        'tenant_id',
        'transaction_reference',
        'updated_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount_paid' => 'decimal:2',
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

    public function allocations(): HasMany
    {
        return $this->hasMany(PaymentAllocation::class, 'payment_id');
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class, 'payment_id');
    }
}
