<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryCategory extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'inventory_categories';

    protected $fillable = [
        'category_code',
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
