<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountingCategory extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'accounting_categories';

    protected $fillable = [
        'category_code',
        'category_type',
        'created_by',
        'deleted_by',
        'description',
        'metadata',
        'name',
        'status',
        'updated_by',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];
}
