<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppNotification extends Model
{
    use Auditable, SoftDeletes;

    protected $table = 'notifications';

    protected $fillable = [
        'channel',
        'created_by',
        'deleted_by',
        'message',
        'metadata',
        'notification_no',
        'notification_type',
        'read_at',
        'recipient',
        'reference_id',
        'reference_type',
        'scheduled_at',
        'sent_at',
        'status',
        'subject',
        'template_id',
        'tenant_id',
        'updated_by',
        'user_id',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'read_at' => 'datetime',
        'metadata' => 'array',
    ];
}
