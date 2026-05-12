<?php

namespace App\Http\Controllers\Admin;

use App\Models\UtilityType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Utility Types.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class UtilityTypeController extends BaseCrudController
{
    protected string $modelClass = UtilityType::class;
    protected string $routeSlug = 'utility-types';
    protected ?string $permissionModule = 'utility_types';
    protected string $singular = 'Utility Type';
    protected string $plural = 'Utility Types';
    protected array $with = [];
    protected array $searchable = ['utility_code', 'name'];
    protected array $columns = [
        'id' => '#',
        'utility_code' => 'Code',
        'name' => 'Name',
        'unit' => 'Unit',
        'billing_method' => 'Method',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('utility_code', 'Code', true),
            \App\Support\CrudField::text('name', 'Name', true),
            \App\Support\CrudField::text('unit', 'Unit', false),
            \App\Support\CrudField::select('billing_method', 'Billing Method', ['metered' => 'Metered', 'flat' => 'Flat', 'tiered' => 'Tiered'], false),
            \App\Support\CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'utility_code' => ['required', 'string', 'max:191'],
            'name' => ['required', 'string', 'max:191'],
            'unit' => ['nullable', 'string', 'max:191'],
            'billing_method' => ['nullable', 'string', 'max:191'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}