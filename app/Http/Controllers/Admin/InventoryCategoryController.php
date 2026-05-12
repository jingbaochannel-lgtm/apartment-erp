<?php

namespace App\Http\Controllers\Admin;

use App\Models\InventoryCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Inventory Categories.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class InventoryCategoryController extends BaseCrudController
{
    protected string $modelClass = InventoryCategory::class;
    protected string $routeSlug = 'inventory-categories';
    protected ?string $permissionModule = 'inventory_categories';
    protected string $singular = 'Inventory Category';
    protected string $plural = 'Inventory Categories';
    protected array $with = [];
    protected array $searchable = ['category_code', 'name'];
    protected array $columns = [
        'id' => '#',
        'category_code' => 'Code',
        'name' => 'Name',
        'description' => 'Description',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('category_code', 'Code', true),
            \App\Support\CrudField::text('name', 'Name', true),
            \App\Support\CrudField::textarea('description', 'Description', false, 3),
            \App\Support\CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'category_code' => ['required', 'string', 'max:191'],
            'name' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}