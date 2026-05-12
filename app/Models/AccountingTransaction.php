<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountingTransaction extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'accounting_transactions';

    protected $fillable = [
        'accounting_category_id',
        'amount',
        'attachment_path',
        'created_by',
        'deleted_by',
        'description',
        'metadata',
        'payment_method',
        'reference_id',
        'reference_type',
        'status',
        'transaction_date',
        'transaction_no',
        'transaction_type',
        'updated_by',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'decimal:2',
        'metadata' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(AccountingCategory::class, 'accounting_category_id');
    }
}
