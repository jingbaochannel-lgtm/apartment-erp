<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollItem extends Model
{
    protected $table = 'payroll_items';

    protected $fillable = [
        'amount',
        'description',
        'item_type',
        'payroll_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];
}
