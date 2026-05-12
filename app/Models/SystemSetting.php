<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Models\Concerns\BelongsToApartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemSetting extends Model
{
    use SoftDeletes, Auditable, BelongsToApartment;

    protected $table = 'system_settings';

    protected $fillable = [
        'apartment_profile_id',
        'created_by',
        'deleted_by',
        'description',
        'is_encrypted',
        'metadata',
        'setting_group',
        'setting_key',
        'setting_value',
        'updated_by',
        'value_type',
    ];

    protected $casts = [
        'is_encrypted' => 'boolean',
        'metadata' => 'array',
    ];
}
