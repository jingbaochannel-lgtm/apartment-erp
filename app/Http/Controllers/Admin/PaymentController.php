<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Payments.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class PaymentController extends BaseCrudController
{
    protected string $modelClass = Payment::class;
    protected string $routeSlug = 'payments';
    protected ?string $permissionModule = 'payments';
    protected string $singular = 'Payment';
    protected string $plural = 'Payments';
    protected array $with = ['tenant', 'invoice'];
    protected array $searchable = ['payment_no', 'transaction_reference'];
    protected array $columns = [
        'id' => '#',
        'payment_no' => 'No.',
        'tenant.full_name' => 'Tenant',
        'invoice.invoice_no' => 'Invoice',
        'amount_paid' => 'Amount',
        'payment_method' => 'Method',
        'payment_date' => 'Date',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('payment_no', 'No.', true),
            \App\Support\CrudField::select('tenant_id', 'Tenant', static::options(\App\Models\Tenant::class), true),
            \App\Support\CrudField::select('invoice_id', 'Invoice', static::options(\App\Models\Invoice::class), false),
            \App\Support\CrudField::date('payment_date', 'Date', true),
            \App\Support\CrudField::decimal('amount_paid', 'Amount', true),
            \App\Support\CrudField::select('payment_method', 'Method', ['cash' => 'Cash', 'bank_transfer' => 'Bank Transfer', 'credit_card' => 'Credit Card', 'aba_pay' => 'ABA Pay', 'wing' => 'Wing', 'other' => 'Other'], false),
            \App\Support\CrudField::text('transaction_reference', 'Reference', false),
            \App\Support\CrudField::text('slip_path', 'Slip Path', false),
            \App\Support\CrudField::textarea('notes', 'Notes', false, 3),
            \App\Support\CrudField::select('status', 'Status', ['pending' => 'Pending', 'completed' => 'Completed', 'failed' => 'Failed', 'cancelled' => 'Cancelled'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'payment_no' => ['required', 'string', 'max:191'],
            'tenant_id' => ['required', 'string', 'max:191'],
            'invoice_id' => ['nullable', 'string', 'max:191'],
            'payment_date' => ['required', 'date'],
            'amount_paid' => ['required', 'numeric'],
            'payment_method' => ['nullable', 'string', 'max:191'],
            'transaction_reference' => ['nullable', 'string', 'max:191'],
            'slip_path' => ['nullable', 'string', 'max:191'],
            'notes' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}