<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payroll;
use App\Models\Staff;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Payrolls.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class PayrollController extends BaseCrudController
{
    protected string $modelClass = Payroll::class;

    protected string $routeSlug = 'payrolls';

    protected ?string $permissionModule = 'payrolls';

    protected string $singular = 'Payroll';

    protected string $plural = 'Payrolls';

    protected array $with = [];

    protected array $searchable = ['payroll_no', 'payroll_month'];

    protected array $columns = [
        'id' => '#',
        'payroll_no' => 'No.',
        'payroll_month' => 'Month',
        'net_salary' => 'Net Salary',
        'paid_date' => 'Paid On',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::text('payroll_no', 'No.', true),
            CrudField::select('staff_id', 'Staff', static::options(Staff::class), true),
            CrudField::text('payroll_month', 'Month (YYYY-MM)', false),
            CrudField::decimal('basic_salary', 'Basic Salary', false),
            CrudField::decimal('overtime_amount', 'Overtime', false),
            CrudField::decimal('allowance_amount', 'Allowance', false),
            CrudField::decimal('deduction_amount', 'Deduction', false),
            CrudField::decimal('bonus_amount', 'Bonus', false),
            CrudField::decimal('net_salary', 'Net Salary', false),
            CrudField::date('paid_date', 'Paid Date', false),
            CrudField::select('status', 'Status', ['draft' => 'Draft', 'approved' => 'Approved', 'paid' => 'Paid'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'payroll_no' => ['required', 'string', 'max:191'],
            'staff_id' => ['required', 'string', 'max:191'],
            'payroll_month' => ['nullable', 'string', 'max:191'],
            'basic_salary' => ['nullable', 'numeric'],
            'overtime_amount' => ['nullable', 'numeric'],
            'allowance_amount' => ['nullable', 'numeric'],
            'deduction_amount' => ['nullable', 'numeric'],
            'bonus_amount' => ['nullable', 'numeric'],
            'net_salary' => ['nullable', 'numeric'],
            'paid_date' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
