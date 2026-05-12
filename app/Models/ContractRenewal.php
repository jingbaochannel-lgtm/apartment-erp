<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractRenewal extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'contract_renewals';

    protected $fillable = [
        'contract_id',
        'created_by',
        'deleted_by',
        'metadata',
        'new_deposit_amount',
        'new_end_date',
        'new_monthly_rent',
        'new_start_date',
        'old_deposit_amount',
        'old_end_date',
        'old_monthly_rent',
        'renewal_document_path',
        'renewal_no',
        'status',
        'updated_by',
    ];

    protected $casts = [
        'old_end_date' => 'date',
        'new_start_date' => 'date',
        'new_end_date' => 'date',
        'old_monthly_rent' => 'decimal:2',
        'new_monthly_rent' => 'decimal:2',
        'old_deposit_amount' => 'decimal:2',
        'new_deposit_amount' => 'decimal:2',
        'metadata' => 'array',
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(RentalContract::class, 'contract_id');
    }
}
