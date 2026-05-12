<?php

namespace App\Http\Controllers\Admin;

use App\Models\Complaint;
use App\Models\Room;
use App\Models\Staff;
use App\Models\Tenant;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Complaints.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class ComplaintController extends BaseCrudController
{
    protected string $modelClass = Complaint::class;

    protected string $routeSlug = 'complaints';

    protected ?string $permissionModule = 'complaints';

    protected string $singular = 'Complaint';

    protected string $plural = 'Complaints';

    protected array $with = ['tenant', 'room'];

    protected array $searchable = ['complaint_no', 'complaint_type'];

    protected array $columns = [
        'id' => '#',
        'complaint_no' => 'No.',
        'tenant.full_name' => 'Tenant',
        'room.room_code' => 'Room',
        'complaint_type' => 'Type',
        'received_date' => 'Date',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::text('complaint_no', 'No.', true),
            CrudField::select('tenant_id', 'Tenant', static::options(Tenant::class), false),
            CrudField::select('room_id', 'Room', static::options(Room::class), false),
            CrudField::select('responsible_staff_id', 'Responsible Staff', static::options(Staff::class), false),
            CrudField::text('complaint_type', 'Type', false),
            CrudField::textarea('description', 'Description', false, 3),
            CrudField::date('received_date', 'Received Date', false),
            CrudField::date('resolved_date', 'Resolved Date', false),
            CrudField::select('status', 'Status', ['open' => 'Open', 'in_progress' => 'In Progress', 'resolved' => 'Resolved', 'closed' => 'Closed'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'complaint_no' => ['required', 'string', 'max:191'],
            'tenant_id' => ['nullable', 'string', 'max:191'],
            'room_id' => ['nullable', 'string', 'max:191'],
            'responsible_staff_id' => ['nullable', 'string', 'max:191'],
            'complaint_type' => ['nullable', 'string', 'max:191'],
            'description' => ['nullable', 'string'],
            'received_date' => ['nullable', 'date'],
            'resolved_date' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
