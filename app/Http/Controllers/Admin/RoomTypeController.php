<?php

namespace App\Http\Controllers\Admin;

use App\Models\RoomType;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Room Types.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class RoomTypeController extends BaseCrudController
{
    protected string $modelClass = RoomType::class;

    protected string $routeSlug = 'room-types';

    protected ?string $permissionModule = 'room_types';

    protected string $singular = 'Room Type';

    protected string $plural = 'Room Types';

    protected array $with = [];

    protected array $searchable = ['type_code', 'name'];

    protected array $columns = [
        'id' => '#',
        'type_code' => 'Code',
        'name' => 'Name',
        'default_monthly_rent' => 'Monthly Rent',
        'default_deposit_amount' => 'Deposit',
        'default_capacity' => 'Capacity',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::text('type_code', 'Code', true),
            CrudField::text('name', 'Name', true),
            CrudField::textarea('description', 'Description', false, 3),
            CrudField::decimal('default_monthly_rent', 'Default Monthly Rent', false),
            CrudField::decimal('default_deposit_amount', 'Default Deposit', false),
            CrudField::number('default_capacity', 'Default Capacity', false),
            CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'type_code' => ['required', 'string', 'max:191'],
            'name' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string'],
            'default_monthly_rent' => ['nullable', 'numeric'],
            'default_deposit_amount' => ['nullable', 'numeric'],
            'default_capacity' => ['nullable', 'integer'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
