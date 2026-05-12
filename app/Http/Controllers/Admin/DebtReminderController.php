<?php

namespace App\Http\Controllers\Admin;

use App\Models\DebtReminder;
use App\Models\Invoice;
use App\Models\Tenant;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Debt Reminders.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class DebtReminderController extends BaseCrudController
{
    protected string $modelClass = DebtReminder::class;

    protected string $routeSlug = 'debt-reminders';

    protected ?string $permissionModule = 'debt_reminders';

    protected string $singular = 'Debt Reminder';

    protected string $plural = 'Debt Reminders';

    protected array $with = ['tenant', 'invoice'];

    protected array $searchable = ['reminder_no'];

    protected array $columns = [
        'id' => '#',
        'reminder_no' => 'No.',
        'tenant.full_name' => 'Tenant',
        'invoice.invoice_no' => 'Invoice',
        'reminder_channel' => 'Channel',
        'amount_due' => 'Due',
        'overdue_days' => 'Days Late',
        'delivery_status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::text('reminder_no', 'No.', true),
            CrudField::select('tenant_id', 'Tenant', static::options(Tenant::class), true),
            CrudField::select('invoice_id', 'Invoice', static::options(Invoice::class), false),
            CrudField::select('reminder_channel', 'Channel', ['sms' => 'SMS', 'email' => 'Email', 'phone' => 'Phone', 'in_person' => 'In Person'], false),
            CrudField::date('reminder_date', 'Date', false),
            CrudField::decimal('amount_due', 'Amount Due', false),
            CrudField::number('overdue_days', 'Overdue Days', false),
            CrudField::textarea('message', 'Message', false, 3),
            CrudField::select('delivery_status', 'Delivery Status', ['pending' => 'Pending', 'sent' => 'Sent', 'failed' => 'Failed'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'reminder_no' => ['required', 'string', 'max:191'],
            'tenant_id' => ['required', 'string', 'max:191'],
            'invoice_id' => ['nullable', 'string', 'max:191'],
            'reminder_channel' => ['nullable', 'string', 'max:191'],
            'reminder_date' => ['nullable', 'date'],
            'amount_due' => ['nullable', 'numeric'],
            'overdue_days' => ['nullable', 'integer'],
            'message' => ['nullable', 'string'],
            'delivery_status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
