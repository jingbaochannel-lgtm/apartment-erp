<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'receipts';

    protected $fillable = [
        'amount_paid',
        'balance_due',
        'created_by',
        'deleted_by',
        'invoice_id',
        'metadata',
        'payment_id',
        'pdf_path',
        'receipt_date',
        'receipt_no',
        'received_by',
        'status',
        'updated_by',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'balance_due' => 'decimal:2',
        'receipt_date' => 'date',
        'metadata' => 'array',
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
