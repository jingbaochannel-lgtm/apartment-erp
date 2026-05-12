<?php

namespace App\Http\Controllers\Admin;

use App\Models\AppNotification;
use App\Models\NotificationTemplate;
use App\Models\SystemUser;
use App\Models\Tenant;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

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
            CrudField::text('notification_no', 'No.', true),
            CrudField::select('template_id', 'Template', static::options(NotificationTemplate::class), false),
            CrudField::select('tenant_id', 'Tenant', static::options(Tenant::class), false),
            CrudField::select('user_id', 'User', static::options(SystemUser::class), false),
            CrudField::select('channel', 'Channel', ['email' => 'Email', 'sms' => 'SMS', 'in_app' => 'In-app', 'push' => 'Push'], false),
            CrudField::text('notification_type', 'Type', false),
            CrudField::text('recipient', 'Recipient', false),
            CrudField::text('subject', 'Subject', false),
            CrudField::textarea('message', 'Message', false, 4),
            CrudField::datetime('scheduled_at', 'Scheduled At', false),
            CrudField::datetime('sent_at', 'Sent At', false),
            CrudField::select('status', 'Status', ['scheduled' => 'Scheduled', 'sent' => 'Sent', 'failed' => 'Failed', 'read' => 'Read'], false),
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
