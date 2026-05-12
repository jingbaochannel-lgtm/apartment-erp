<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Receipt;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Receipts.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class ReceiptController extends BaseCrudController
{
    protected string $modelClass = Receipt::class;

    protected string $routeSlug = 'receipts';

    protected ?string $permissionModule = 'receipts';

    protected string $singular = 'Receipt';

    protected string $plural = 'Receipts';

    protected array $with = ['payment', 'invoice'];

    protected array $searchable = ['receipt_no'];

    protected array $columns = [
        'id' => '#',
        'receipt_no' => 'No.',
        'invoice.invoice_no' => 'Invoice',
        'amount_paid' => 'Paid',
        'balance_due' => 'Balance',
        'receipt_date' => 'Date',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::text('receipt_no', 'No.', true),
            CrudField::select('payment_id', 'Payment', static::options(Payment::class), false),
            CrudField::select('invoice_id', 'Invoice', static::options(Invoice::class), false),
            CrudField::decimal('amount_paid', 'Amount Paid', false),
            CrudField::decimal('balance_due', 'Balance Due', false),
            CrudField::date('receipt_date', 'Date', false),
            CrudField::text('received_by', 'Received By', false),
            CrudField::text('pdf_path', 'PDF Path', false),
            CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'receipt_no' => ['required', 'string', 'max:191'],
            'payment_id' => ['nullable', 'string', 'max:191'],
            'invoice_id' => ['nullable', 'string', 'max:191'],
            'amount_paid' => ['nullable', 'numeric'],
            'balance_due' => ['nullable', 'numeric'],
            'receipt_date' => ['nullable', 'date'],
            'received_by' => ['nullable', 'string', 'max:191'],
            'pdf_path' => ['nullable', 'string', 'max:191'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
