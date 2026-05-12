<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Models\RentalContract;
use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'invoices';

    protected $fillable = [
        'balance_due',
        'billing_month',
        'contract_id',
        'created_by',
        'deleted_by',
        'discount',
        'due_date',
        'electricity_fee',
        'grand_total',
        'invoice_date',
        'invoice_no',
        'metadata',
        'old_balance',
        'paid_amount',
        'pdf_path',
        'penalty',
        'room_fee',
        'room_id',
        'service_fee',
        'status',
        'subtotal',
        'tenant_id',
        'updated_by',
        'water_fee',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'room_fee' => 'decimal:2',
        'water_fee' => 'decimal:2',
        'electricity_fee' => 'decimal:2',
        'service_fee' => 'decimal:2',
        'old_balance' => 'decimal:2',
        'discount' => 'decimal:2',
        'penalty' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance_due' => 'decimal:2',
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

    public function contract(): BelongsTo
    {
        return $this->belongsTo(RentalContract::class, 'contract_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(\App\Models\InvoiceItem::class, 'invoice_id');
    }

    public function allocations(): HasMany
    {
        return $this->hasMany(\App\Models\PaymentAllocation::class, 'invoice_id');
    }
}
