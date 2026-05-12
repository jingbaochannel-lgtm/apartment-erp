<?php

namespace App\Http\Controllers\Admin;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Reservations.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class ReservationController extends BaseCrudController
{
    protected string $modelClass = Reservation::class;
    protected string $routeSlug = 'reservations';
    protected ?string $permissionModule = 'reservations';
    protected string $singular = 'Reservation';
    protected string $plural = 'Reservations';
    protected array $with = ['room', 'tenant'];
    protected array $searchable = ['reservation_no', 'customer_name', 'phone'];
    protected array $columns = [
        'id' => '#',
        'reservation_no' => 'No.',
        'room.room_code' => 'Room',
        'customer_name' => 'Customer',
        'phone' => 'Phone',
        'planned_move_in_date' => 'Planned Move-in',
        'deposit_amount' => 'Deposit',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('reservation_no', 'No.', true),
            \App\Support\CrudField::select('room_id', 'Room', static::options(\App\Models\Room::class), true),
            \App\Support\CrudField::select('tenant_id', 'Tenant', static::options(\App\Models\Tenant::class), false),
            \App\Support\CrudField::text('customer_name', 'Customer', false),
            \App\Support\CrudField::text('phone', 'Phone', false),
            \App\Support\CrudField::email('email', 'Email', false),
            \App\Support\CrudField::date('planned_move_in_date', 'Planned Move-in', false),
            \App\Support\CrudField::decimal('deposit_amount', 'Deposit', false),
            \App\Support\CrudField::date('deposit_paid_date', 'Deposit Paid', false),
            \App\Support\CrudField::textarea('notes', 'Notes', false, 3),
            \App\Support\CrudField::select('status', 'Status', ['pending' => 'Pending', 'confirmed' => 'Confirmed', 'cancelled' => 'Cancelled', 'converted' => 'Converted'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'reservation_no' => ['required', 'string', 'max:191'],
            'room_id' => ['required', 'string', 'max:191'],
            'tenant_id' => ['nullable', 'string', 'max:191'],
            'customer_name' => ['nullable', 'string', 'max:191'],
            'phone' => ['nullable', 'string', 'max:191'],
            'email' => ['nullable', 'email', 'max:191'],
            'planned_move_in_date' => ['nullable', 'date'],
            'deposit_amount' => ['nullable', 'numeric'],
            'deposit_paid_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}