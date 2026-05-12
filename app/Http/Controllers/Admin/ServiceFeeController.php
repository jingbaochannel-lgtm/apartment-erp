<?php

namespace App\Http\Controllers\Admin;

use App\Models\ServiceFee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Service Fees.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class ServiceFeeController extends BaseCrudController
{
    protected string $modelClass = ServiceFee::class;
    protected string $routeSlug = 'service-fees';
    protected ?string $permissionModule = 'service_fees';
    protected string $singular = 'Service Fee';
    protected string $plural = 'Service Fees';
    protected array $with = [];
    protected array $searchable = ['service_code', 'name'];
    protected array $columns = [
        'id' => '#',
        'service_code' => 'Code',
        'name' => 'Name',
        'fee_type' => 'Type',
        'amount' => 'Amount',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('service_code', 'Code', true),
            \App\Support\CrudField::text('name', 'Name', true),
            \App\Support\CrudField::select('fee_type', 'Type', ['monthly' => 'Monthly', 'one_time' => 'One-time', 'metered' => 'Metered'], false),
            \App\Support\CrudField::decimal('amount', 'Amount', false),
            \App\Support\CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'service_code' => ['required', 'string', 'max:191'],
            'name' => ['required', 'string', 'max:191'],
            'fee_type' => ['nullable', 'string', 'max:191'],
            'amount' => ['nullable', 'numeric'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}