<?php

namespace App\Http\Controllers\Admin;

use App\Models\AppNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Notifications.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class NotificationController extends BaseCrudController
{
    protected string $modelClass = AppNotification::class;
    protected string $routeSlug = 'notifications';
    protected ?string $permissionModule = 'notifications';
    protected string $singular = 'Notification';
    protected string $plural = 'Notifications';
    protected array $with = [];
    protected array $searchable = ['notification_no', 'recipient', 'subject'];
    protected array $columns = [
        'id' => '#',
        'notification_no' => 'No.',
        'channel' => 'Channel',
        'recipient' => 'Recipient',
        'subject' => 'Subject',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('notification_no', 'No.', true),
            \App\Support\CrudField::select('template_id', 'Template', static::options(\App\Models\NotificationTemplate::class), false),
            \App\Support\CrudField::select('tenant_id', 'Tenant', static::options(\App\Models\Tenant::class), false),
            \App\Support\CrudField::select('user_id', 'User', static::options(\App\Models\SystemUser::class), false),
            \App\Support\CrudField::select('channel', 'Channel', ['email' => 'Email', 'sms' => 'SMS', 'in_app' => 'In-app', 'push' => 'Push'], false),
            \App\Support\CrudField::text('notification_type', 'Type', false),
            \App\Support\CrudField::text('recipient', 'Recipient', false),
            \App\Support\CrudField::text('subject', 'Subject', false),
            \App\Support\CrudField::textarea('message', 'Message', false, 4),
            \App\Support\CrudField::datetime('scheduled_at', 'Scheduled At', false),
            \App\Support\CrudField::datetime('sent_at', 'Sent At', false),
            \App\Support\CrudField::select('status', 'Status', ['scheduled' => 'Scheduled', 'sent' => 'Sent', 'failed' => 'Failed', 'read' => 'Read'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'notification_no' => ['required', 'string', 'max:191'],
            'template_id' => ['nullable', 'string', 'max:191'],
            'tenant_id' => ['nullable', 'string', 'max:191'],
            'user_id' => ['nullable', 'string', 'max:191'],
            'channel' => ['nullable', 'string', 'max:191'],
            'notification_type' => ['nullable', 'string', 'max:191'],
            'recipient' => ['nullable', 'string', 'max:191'],
            'subject' => ['nullable', 'string', 'max:191'],
            'message' => ['nullable', 'string'],
            'scheduled_at' => ['nullable', 'date'],
            'sent_at' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}