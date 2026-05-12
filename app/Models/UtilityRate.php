<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Models\UtilityType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UtilityRate extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'utility_rates';

    protected $fillable = [
        'created_by',
        'deleted_by',
        'effective_from',
        'effective_to',
        'metadata',
        'minimum_charge',
        'price_per_unit',
        'status',
        'updated_by',
        'utility_type_id',
    ];

    protected $casts = [
        'price_per_unit' => 'decimal:4',
        'minimum_charge' => 'decimal:2',
        'effective_from' => 'date',
        'effective_to' => 'date',
        'metadata' => 'array',
    ];

    public function utilityType(): BelongsTo
    {
        return $this->belongsTo(UtilityType::class, 'utility_type_id');
    }
}
