<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContractTermination;
use App\Models\RentalContract;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Contract Terminations.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class ContractTerminationController extends BaseCrudController
{
    protected string $modelClass = ContractTermination::class;

    protected string $routeSlug = 'contract-terminations';

    protected ?string $permissionModule = 'contract_terminations';

    protected string $singular = 'Contract Termination';

    protected string $plural = 'Contract Terminations';

    protected array $with = ['contract'];

    protected array $searchable = ['termination_no', 'reason'];

    protected array $columns = [
        'id' => '#',
        'termination_no' => 'No.',
        'contract.contract_no' => 'Contract',
        'termination_date' => 'Date',
        'outstanding_balance' => 'Outstanding',
        'deposit_refund' => 'Refund',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::text('termination_no', 'No.', true),
            CrudField::select('contract_id', 'Contract', static::options(RentalContract::class), true),
            CrudField::date('termination_date', 'Termination Date', false),
            CrudField::textarea('reason', 'Reason', false, 3),
            CrudField::decimal('outstanding_balance', 'Outstanding Balance', false),
            CrudField::decimal('deposit_deduction', 'Deposit Deduction', false),
            CrudField::decimal('deposit_refund', 'Deposit Refund', false),
            CrudField::text('termination_letter_path', 'Letter Path', false),
            CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'termination_no' => ['required', 'string', 'max:191'],
            'contract_id' => ['required', 'string', 'max:191'],
            'termination_date' => ['nullable', 'date'],
            'reason' => ['nullable', 'string'],
            'outstanding_balance' => ['nullable', 'numeric'],
            'deposit_deduction' => ['nullable', 'numeric'],
            'deposit_refund' => ['nullable', 'numeric'],
            'termination_letter_path' => ['nullable', 'string', 'max:191'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
