<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentalContract extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'rental_contracts';

    protected $fillable = [
        'contract_no',
        'created_by',
        'deleted_by',
        'deposit_amount',
        'end_date',
        'metadata',
        'monthly_rent',
        'payment_due_day',
        'reservation_id',
        'room_id',
        'signed_contract_path',
        'signed_date',
        'start_date',
        'status',
        'tenant_id',
        'terms_conditions',
        'updated_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'signed_date' => 'date',
        'monthly_rent' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
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

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

    public function renewals(): HasMany
    {
        return $this->hasMany(ContractRenewal::class, 'contract_id');
    }

    public function terminations(): HasMany
    {
        return $this->hasMany(ContractTermination::class, 'contract_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'contract_id');
    }
}
