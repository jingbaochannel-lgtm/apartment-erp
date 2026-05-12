<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'reservations';

    protected $fillable = [
        'created_by',
        'customer_name',
        'deleted_by',
        'deposit_amount',
        'deposit_paid_date',
        'email',
        'metadata',
        'notes',
        'phone',
        'planned_move_in_date',
        'reservation_no',
        'room_id',
        'status',
        'tenant_id',
        'updated_by',
    ];

    protected $casts = [
        'planned_move_in_date' => 'date',
        'deposit_paid_date' => 'date',
        'deposit_amount' => 'decimal:2',
        'metadata' => 'array',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
