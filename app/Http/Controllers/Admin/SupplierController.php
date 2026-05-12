<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

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
            CrudField::text('supplier_code', 'Code', true),
            CrudField::text('supplier_name', 'Name', true),
            CrudField::text('phone', 'Phone', false),
            CrudField::email('email', 'Email', false),
            CrudField::textarea('address', 'Address', false, 3),
            CrudField::text('contact_person', 'Contact Person', false),
            CrudField::text('payment_term', 'Payment Term', false),
            CrudField::decimal('rating', 'Rating', false),
            CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
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
