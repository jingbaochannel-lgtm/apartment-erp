<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'suppliers';

    protected $fillable = [
        'address',
        'contact_person',
        'created_by',
        'deleted_by',
        'email',
        'metadata',
        'payment_term',
        'phone',
        'rating',
        'status',
        'supplier_code',
        'supplier_name',
        'updated_by',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'metadata' => 'array',
    ];
}
