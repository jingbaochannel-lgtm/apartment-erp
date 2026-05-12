<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContractRenewal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Contract Renewals.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class ContractRenewalController extends BaseCrudController
{
    protected string $modelClass = ContractRenewal::class;
    protected string $routeSlug = 'contract-renewals';
    protected ?string $permissionModule = 'contract_renewals';
    protected string $singular = 'Contract Renewal';
    protected string $plural = 'Contract Renewals';
    protected array $with = ['contract'];
    protected array $searchable = ['renewal_no'];
    protected array $columns = [
        'id' => '#',
        'renewal_no' => 'No.',
        'contract.contract_no' => 'Contract',
        'new_start_date' => 'New Start',
        'new_end_date' => 'New End',
        'new_monthly_rent' => 'New Rent',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('renewal_no', 'No.', true),
            \App\Support\CrudField::select('contract_id', 'Contract', static::options(\App\Models\RentalContract::class), true),
            \App\Support\CrudField::date('old_end_date', 'Old End Date', false),
            \App\Support\CrudField::date('new_start_date', 'New Start Date', false),
            \App\Support\CrudField::date('new_end_date', 'New End Date', false),
            \App\Support\CrudField::decimal('old_monthly_rent', 'Old Rent', false),
            \App\Support\CrudField::decimal('new_monthly_rent', 'New Rent', false),
            \App\Support\CrudField::decimal('old_deposit_amount', 'Old Deposit', false),
            \App\Support\CrudField::decimal('new_deposit_amount', 'New Deposit', false),
            \App\Support\CrudField::text('renewal_document_path', 'Document Path', false),
            \App\Support\CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'renewal_no' => ['required', 'string', 'max:191'],
            'contract_id' => ['required', 'string', 'max:191'],
            'old_end_date' => ['nullable', 'date'],
            'new_start_date' => ['nullable', 'date'],
            'new_end_date' => ['nullable', 'date'],
            'old_monthly_rent' => ['nullable', 'numeric'],
            'new_monthly_rent' => ['nullable', 'numeric'],
            'old_deposit_amount' => ['nullable', 'numeric'],
            'new_deposit_amount' => ['nullable', 'numeric'],
            'renewal_document_path' => ['nullable', 'string', 'max:191'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}