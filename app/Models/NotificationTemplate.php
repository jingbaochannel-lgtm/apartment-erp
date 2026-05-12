<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationTemplate extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'notification_templates';

    protected $fillable = [
        'body',
        'channel',
        'created_by',
        'deleted_by',
        'metadata',
        'status',
        'subject',
        'template_code',
        'template_type',
        'updated_by',
        'variables',
    ];

    protected $casts = [
        'variables' => 'array',
        'metadata' => 'array',
    ];
}
