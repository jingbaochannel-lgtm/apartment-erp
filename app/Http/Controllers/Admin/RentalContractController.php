<?php

namespace App\Http\Controllers\Admin;

use App\Models\RentalContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Rental Contracts.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class RentalContractController extends BaseCrudController
{
    protected string $modelClass = RentalContract::class;
    protected string $routeSlug = 'rental-contracts';
    protected ?string $permissionModule = 'rental_contracts';
    protected string $singular = 'Rental Contract';
    protected string $plural = 'Rental Contracts';
    protected array $with = ['tenant', 'room'];
    protected array $searchable = ['contract_no'];
    protected array $columns = [
        'id' => '#',
        'contract_no' => 'No.',
        'tenant.full_name' => 'Tenant',
        'room.room_code' => 'Room',
        'start_date' => 'Start',
        'end_date' => 'End',
        'monthly_rent' => 'Monthly Rent',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('contract_no', 'No.', true),
            \App\Support\CrudField::select('tenant_id', 'Tenant', static::options(\App\Models\Tenant::class), true),
            \App\Support\CrudField::select('room_id', 'Room', static::options(\App\Models\Room::class), true),
            \App\Support\CrudField::select('reservation_id', 'Reservation', static::options(\App\Models\Reservation::class), false),
            \App\Support\CrudField::date('start_date', 'Start Date', true),
            \App\Support\CrudField::date('end_date', 'End Date', true),
            \App\Support\CrudField::decimal('monthly_rent', 'Monthly Rent', true),
            \App\Support\CrudField::decimal('deposit_amount', 'Deposit', false),
            \App\Support\CrudField::number('payment_due_day', 'Payment Due Day', false),
            \App\Support\CrudField::textarea('terms_conditions', 'Terms & Conditions', false, 6),
            \App\Support\CrudField::text('signed_contract_path', 'Signed Contract Path', false),
            \App\Support\CrudField::date('signed_date', 'Signed Date', false),
            \App\Support\CrudField::select('status', 'Status', ['draft' => 'Draft', 'active' => 'Active', 'expired' => 'Expired', 'terminated' => 'Terminated'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'contract_no' => ['required', 'string', 'max:191'],
            'tenant_id' => ['required', 'string', 'max:191'],
            'room_id' => ['required', 'string', 'max:191'],
            'reservation_id' => ['nullable', 'string', 'max:191'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'monthly_rent' => ['required', 'numeric'],
            'deposit_amount' => ['nullable', 'numeric'],
            'payment_due_day' => ['nullable', 'integer'],
            'terms_conditions' => ['nullable', 'string'],
            'signed_contract_path' => ['nullable', 'string', 'max:191'],
            'signed_date' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}