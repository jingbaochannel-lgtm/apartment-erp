<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Suppliers.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class SupplierController extends BaseCrudController
{
    protected string $modelClass = Supplier::class;
    protected string $routeSlug = 'suppliers';
    protected ?string $permissionModule = 'suppliers';
    protected string $singular = 'Supplier';
    protected string $plural = 'Suppliers';
    protected array $with = [];
    protected array $searchable = ['supplier_code', 'supplier_name', 'phone', 'email'];
    protected array $columns = [
        'id' => '#',
        'supplier_code' => 'Code',
        'supplier_name' => 'Name',
        'phone' => 'Phone',
        'rating' => 'Rating',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('supplier_code', 'Code', true),
            \App\Support\CrudField::text('supplier_name', 'Name', true),
            \App\Support\CrudField::text('phone', 'Phone', false),
            \App\Support\CrudField::email('email', 'Email', false),
            \App\Support\CrudField::textarea('address', 'Address', false, 3),
            \App\Support\CrudField::text('contact_person', 'Contact Person', false),
            \App\Support\CrudField::text('payment_term', 'Payment Term', false),
            \App\Support\CrudField::decimal('rating', 'Rating', false),
            \App\Support\CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'supplier_code' => ['required', 'string', 'max:191'],
            'supplier_name' => ['required', 'string', 'max:191'],
            'phone' => ['nullable', 'string', 'max:191'],
            'email' => ['nullable', 'email', 'max:191'],
            'address' => ['nullable', 'string'],
            'contact_person' => ['nullable', 'string', 'max:191'],
            'payment_term' => ['nullable', 'string', 'max:191'],
            'rating' => ['nullable', 'numeric'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}