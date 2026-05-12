<?php

namespace App\Http\Controllers\Admin;

use App\Models\Facility;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Facilities.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class FacilityController extends BaseCrudController
{
    protected string $modelClass = Facility::class;

    protected string $routeSlug = 'facilities';

    protected ?string $permissionModule = 'facilities';

    protected string $singular = 'Facility';

    protected string $plural = 'Facilities';

    protected array $with = [];

    protected array $searchable = ['facility_code', 'name', 'category'];

    protected array $columns = [
        'id' => '#',
        'facility_code' => 'Code',
        'name' => 'Name',
        'category' => 'Category',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::text('facility_code', 'Code', true),
            CrudField::text('name', 'Name', true),
            CrudField::text('category', 'Category', false),
            CrudField::textarea('description', 'Description', false, 3),
            CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'facility_code' => ['required', 'string', 'max:191'],
            'name' => ['required', 'string', 'max:191'],
            'category' => ['nullable', 'string', 'max:191'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
