<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payroll extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'payrolls';

    protected $fillable = [
        'allowance_amount',
        'basic_salary',
        'bonus_amount',
        'created_by',
        'deduction_amount',
        'deleted_by',
        'metadata',
        'net_salary',
        'overtime_amount',
        'paid_date',
        'payroll_month',
        'payroll_no',
        'payslip_path',
        'staff_id',
        'status',
        'updated_by',
    ];

    protected $casts = [
        'basic_salary' => 'decimal:2',
        'overtime_amount' => 'decimal:2',
        'allowance_amount' => 'decimal:2',
        'deduction_amount' => 'decimal:2',
        'bonus_amount' => 'decimal:2',
        'net_salary' => 'decimal:2',
        'paid_date' => 'date',
        'metadata' => 'array',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(\App\Models\PayrollItem::class, 'payroll_id');
    }
}
