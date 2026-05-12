<?php

namespace App\Http\Controllers\Admin;

use App\Models\AccountingTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Accounting Transactions.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class AccountingTransactionController extends BaseCrudController
{
    protected string $modelClass = AccountingTransaction::class;
    protected string $routeSlug = 'accounting-transactions';
    protected ?string $permissionModule = 'accounting_transactions';
    protected string $singular = 'Accounting Transaction';
    protected string $plural = 'Accounting Transactions';
    protected array $with = ['category'];
    protected array $searchable = ['transaction_no'];
    protected array $columns = [
        'id' => '#',
        'transaction_no' => 'No.',
        'transaction_type' => 'Type',
        'category.name' => 'Category',
        'amount' => 'Amount',
        'transaction_date' => 'Date',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('transaction_no', 'No.', true),
            \App\Support\CrudField::select('accounting_category_id', 'Category', static::options(\App\Models\AccountingCategory::class), true),
            \App\Support\CrudField::select('transaction_type', 'Type', ['income' => 'Income', 'expense' => 'Expense'], false),
            \App\Support\CrudField::date('transaction_date', 'Date', false),
            \App\Support\CrudField::textarea('description', 'Description', false, 3),
            \App\Support\CrudField::decimal('amount', 'Amount', false),
            \App\Support\CrudField::text('payment_method', 'Payment Method', false),
            \App\Support\CrudField::text('reference_type', 'Reference Type', false),
            \App\Support\CrudField::number('reference_id', 'Reference ID', false),
            \App\Support\CrudField::text('attachment_path', 'Attachment', false),
            \App\Support\CrudField::select('status', 'Status', ['pending' => 'Pending', 'approved' => 'Approved', 'cancelled' => 'Cancelled'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'transaction_no' => ['required', 'string', 'max:191'],
            'accounting_category_id' => ['required', 'string', 'max:191'],
            'transaction_type' => ['nullable', 'string', 'max:191'],
            'transaction_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
            'amount' => ['nullable', 'numeric'],
            'payment_method' => ['nullable', 'string', 'max:191'],
            'reference_type' => ['nullable', 'string', 'max:191'],
            'reference_id' => ['nullable', 'integer'],
            'attachment_path' => ['nullable', 'string', 'max:191'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}