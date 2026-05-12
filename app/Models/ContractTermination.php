<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Models\RentalContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractTermination extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'contract_terminations';

    protected $fillable = [
        'contract_id',
        'created_by',
        'deleted_by',
        'deposit_deduction',
        'deposit_refund',
        'metadata',
        'outstanding_balance',
        'reason',
        'status',
        'termination_date',
        'termination_letter_path',
        'termination_no',
        'updated_by',
    ];

    protected $casts = [
        'termination_date' => 'date',
        'outstanding_balance' => 'decimal:2',
        'deposit_deduction' => 'decimal:2',
        'deposit_refund' => 'decimal:2',
        'metadata' => 'array',
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(RentalContract::class, 'contract_id');
    }
}
