<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Invoices.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class InvoiceController extends BaseCrudController
{
    protected string $modelClass = Invoice::class;
    protected string $routeSlug = 'invoices';
    protected ?string $permissionModule = 'invoices';
    protected string $singular = 'Invoice';
    protected string $plural = 'Invoices';
    protected array $with = ['tenant', 'room'];
    protected array $searchable = ['invoice_no', 'billing_month'];
    protected array $columns = [
        'id' => '#',
        'invoice_no' => 'No.',
        'tenant.full_name' => 'Tenant',
        'room.room_code' => 'Room',
        'billing_month' => 'Month',
        'grand_total' => 'Total',
        'paid_amount' => 'Paid',
        'balance_due' => 'Balance',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('invoice_no', 'No.', true),
            \App\Support\CrudField::select('tenant_id', 'Tenant', static::options(\App\Models\Tenant::class), true),
            \App\Support\CrudField::select('room_id', 'Room', static::options(\App\Models\Room::class), false),
            \App\Support\CrudField::select('contract_id', 'Contract', static::options(\App\Models\RentalContract::class), false),
            \App\Support\CrudField::text('billing_month', 'Month (YYYY-MM)', false),
            \App\Support\CrudField::date('invoice_date', 'Invoice Date', true),
            \App\Support\CrudField::date('due_date', 'Due Date', true),
            \App\Support\CrudField::decimal('room_fee', 'Room Fee', false),
            \App\Support\CrudField::decimal('water_fee', 'Water Fee', false),
            \App\Support\CrudField::decimal('electricity_fee', 'Electricity Fee', false),
            \App\Support\CrudField::decimal('service_fee', 'Service Fee', false),
            \App\Support\CrudField::decimal('old_balance', 'Old Balance', false),
            \App\Support\CrudField::decimal('discount', 'Discount', false),
            \App\Support\CrudField::decimal('penalty', 'Penalty', false),
            \App\Support\CrudField::decimal('subtotal', 'Subtotal', false),
            \App\Support\CrudField::decimal('grand_total', 'Grand Total', false),
            \App\Support\CrudField::decimal('paid_amount', 'Paid', false),
            \App\Support\CrudField::decimal('balance_due', 'Balance Due', false),
            \App\Support\CrudField::select('status', 'Status', ['draft' => 'Draft', 'issued' => 'Issued', 'paid' => 'Paid', 'partial' => 'Partial', 'overdue' => 'Overdue', 'cancelled' => 'Cancelled'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'invoice_no' => ['required', 'string', 'max:191'],
            'tenant_id' => ['required', 'string', 'max:191'],
            'room_id' => ['nullable', 'string', 'max:191'],
            'contract_id' => ['nullable', 'string', 'max:191'],
            'billing_month' => ['nullable', 'string', 'max:191'],
            'invoice_date' => ['required', 'date'],
            'due_date' => ['required', 'date'],
            'room_fee' => ['nullable', 'numeric'],
            'water_fee' => ['nullable', 'numeric'],
            'electricity_fee' => ['nullable', 'numeric'],
            'service_fee' => ['nullable', 'numeric'],
            'old_balance' => ['nullable', 'numeric'],
            'discount' => ['nullable', 'numeric'],
            'penalty' => ['nullable', 'numeric'],
            'subtotal' => ['nullable', 'numeric'],
            'grand_total' => ['nullable', 'numeric'],
            'paid_amount' => ['nullable', 'numeric'],
            'balance_due' => ['nullable', 'numeric'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}