<?php

namespace App\Http\Controllers\Admin;

use App\Models\MoveInRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Move-In Records.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class MoveInRecordController extends BaseCrudController
{
    protected string $modelClass = MoveInRecord::class;
    protected string $routeSlug = 'move-in-records';
    protected ?string $permissionModule = 'move_in_records';
    protected string $singular = 'Move-In Record';
    protected string $plural = 'Move-In Records';
    protected array $with = ['contract', 'tenant', 'room'];
    protected array $searchable = ['move_in_no'];
    protected array $columns = [
        'id' => '#',
        'move_in_no' => 'No.',
        'tenant.full_name' => 'Tenant',
        'room.room_code' => 'Room',
        'move_in_date' => 'Move-in Date',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('move_in_no', 'No.', true),
            \App\Support\CrudField::select('contract_id', 'Contract', static::options(\App\Models\RentalContract::class), false),
            \App\Support\CrudField::select('tenant_id', 'Tenant', static::options(\App\Models\Tenant::class), true),
            \App\Support\CrudField::select('room_id', 'Room', static::options(\App\Models\Room::class), true),
            \App\Support\CrudField::date('move_in_date', 'Date', false),
            \App\Support\CrudField::textarea('room_condition', 'Room Condition', false, 3),
            \App\Support\CrudField::textarea('facility_condition', 'Facility Condition', false, 3),
            \App\Support\CrudField::decimal('water_meter_reading', 'Water Meter', false),
            \App\Support\CrudField::decimal('electric_meter_reading', 'Electric Meter', false),
            \App\Support\CrudField::text('tenant_signature_path', 'Signature', false),
            \App\Support\CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'move_in_no' => ['required', 'string', 'max:191'],
            'contract_id' => ['nullable', 'string', 'max:191'],
            'tenant_id' => ['required', 'string', 'max:191'],
            'room_id' => ['required', 'string', 'max:191'],
            'move_in_date' => ['nullable', 'date'],
            'room_condition' => ['nullable', 'string'],
            'facility_condition' => ['nullable', 'string'],
            'water_meter_reading' => ['nullable', 'numeric'],
            'electric_meter_reading' => ['nullable', 'numeric'],
            'tenant_signature_path' => ['nullable', 'string', 'max:191'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}