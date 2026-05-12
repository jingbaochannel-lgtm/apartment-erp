<?php

namespace App\Http\Controllers\Admin;

use App\Models\AccountingCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Accounting Categories.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class AccountingCategoryController extends BaseCrudController
{
    protected string $modelClass = AccountingCategory::class;
    protected string $routeSlug = 'accounting-categories';
    protected ?string $permissionModule = 'accounting_categories';
    protected string $singular = 'Accounting Category';
    protected string $plural = 'Accounting Categories';
    protected array $with = [];
    protected array $searchable = ['category_code', 'name'];
    protected array $columns = [
        'id' => '#',
        'category_code' => 'Code',
        'name' => 'Name',
        'category_type' => 'Type',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('category_code', 'Code', true),
            \App\Support\CrudField::text('name', 'Name', true),
            \App\Support\CrudField::select('category_type', 'Type', ['income' => 'Income', 'expense' => 'Expense'], false),
            \App\Support\CrudField::textarea('description', 'Description', false, 3),
            \App\Support\CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'category_code' => ['required', 'string', 'max:191'],
            'name' => ['required', 'string', 'max:191'],
            'category_type' => ['nullable', 'string', 'max:191'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}