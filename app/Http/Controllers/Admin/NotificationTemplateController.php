<?php

namespace App\Http\Controllers\Admin;

use App\Models\NotificationTemplate;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Notification Templates.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class NotificationTemplateController extends BaseCrudController
{
    protected string $modelClass = NotificationTemplate::class;

    protected string $routeSlug = 'notification-templates';

    protected ?string $permissionModule = 'notification_templates';

    protected string $singular = 'Notification Template';

    protected string $plural = 'Notification Templates';

    protected array $with = [];

    protected array $searchable = ['template_code', 'subject'];

    protected array $columns = [
        'id' => '#',
        'template_code' => 'Code',
        'template_type' => 'Type',
        'channel' => 'Channel',
        'subject' => 'Subject',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::text('template_code', 'Code', true),
            CrudField::text('template_type', 'Type', false),
            CrudField::select('channel', 'Channel', ['email' => 'Email', 'sms' => 'SMS', 'in_app' => 'In-app', 'push' => 'Push'], false),
            CrudField::text('subject', 'Subject', false),
            CrudField::textarea('body', 'Body', false, 6),
            CrudField::textarea('variables', 'Variables (JSON)', false, 3),
            CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'template_code' => ['required', 'string', 'max:191'],
            'template_type' => ['nullable', 'string', 'max:191'],
            'channel' => ['nullable', 'string', 'max:191'],
            'subject' => ['nullable', 'string', 'max:191'],
            'body' => ['nullable', 'string'],
            'variables' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
