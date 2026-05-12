<?php

namespace App\Http\Controllers\Admin;

use App\Models\MoveOutRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Move-Out Records.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class MoveOutRecordController extends BaseCrudController
{
    protected string $modelClass = MoveOutRecord::class;
    protected string $routeSlug = 'move-out-records';
    protected ?string $permissionModule = 'move_out_records';
    protected string $singular = 'Move-Out Record';
    protected string $plural = 'Move-Out Records';
    protected array $with = ['contract', 'tenant', 'room'];
    protected array $searchable = ['move_out_no'];
    protected array $columns = [
        'id' => '#',
        'move_out_no' => 'No.',
        'tenant.full_name' => 'Tenant',
        'room.room_code' => 'Room',
        'move_out_date' => 'Move-out',
        'deposit_refund' => 'Refund',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('move_out_no', 'No.', true),
            \App\Support\CrudField::select('contract_id', 'Contract', static::options(\App\Models\RentalContract::class), false),
            \App\Support\CrudField::select('tenant_id', 'Tenant', static::options(\App\Models\Tenant::class), true),
            \App\Support\CrudField::select('room_id', 'Room', static::options(\App\Models\Room::class), true),
            \App\Support\CrudField::date('move_out_date', 'Date', false),
            \App\Support\CrudField::textarea('room_condition', 'Room Condition', false, 3),
            \App\Support\CrudField::textarea('damaged_items', 'Damaged Items', false, 3),
            \App\Support\CrudField::decimal('final_water_meter_reading', 'Water Meter', false),
            \App\Support\CrudField::decimal('final_electric_meter_reading', 'Electric Meter', false),
            \App\Support\CrudField::decimal('outstanding_balance', 'Outstanding', false),
            \App\Support\CrudField::decimal('damage_deduction', 'Damage Deduction', false),
            \App\Support\CrudField::decimal('deposit_refund', 'Deposit Refund', false),
            \App\Support\CrudField::text('tenant_signature_path', 'Signature', false),
            \App\Support\CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'move_out_no' => ['required', 'string', 'max:191'],
            'contract_id' => ['nullable', 'string', 'max:191'],
            'tenant_id' => ['required', 'string', 'max:191'],
            'room_id' => ['required', 'string', 'max:191'],
            'move_out_date' => ['nullable', 'date'],
            'room_condition' => ['nullable', 'string'],
            'damaged_items' => ['nullable', 'string'],
            'final_water_meter_reading' => ['nullable', 'numeric'],
            'final_electric_meter_reading' => ['nullable', 'numeric'],
            'outstanding_balance' => ['nullable', 'numeric'],
            'damage_deduction' => ['nullable', 'numeric'],
            'deposit_refund' => ['nullable', 'numeric'],
            'tenant_signature_path' => ['nullable', 'string', 'max:191'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}