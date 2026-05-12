<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tenant;
use App\Models\TenantContact;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Tenant Contacts.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class TenantContactController extends BaseCrudController
{
    protected string $modelClass = TenantContact::class;

    protected string $routeSlug = 'tenant-contacts';

    protected ?string $permissionModule = 'tenant_contacts';

    protected string $singular = 'Tenant Contact';

    protected string $plural = 'Tenant Contacts';

    protected array $with = ['tenant'];

    protected array $searchable = ['name', 'phone', 'email'];

    protected array $columns = [
        'id' => '#',
        'tenant.full_name' => 'Tenant',
        'contact_type' => 'Type',
        'name' => 'Name',
        'phone' => 'Phone',
    ];

    protected function fields(): array
    {
        return [
            CrudField::select('tenant_id', 'Tenant', static::options(Tenant::class), true),
            CrudField::select('contact_type', 'Type', ['emergency' => 'Emergency', 'guarantor' => 'Guarantor', 'family' => 'Family', 'other' => 'Other'], false),
            CrudField::text('name', 'Name', true),
            CrudField::text('relationship', 'Relationship', false),
            CrudField::text('phone', 'Phone', false),
            CrudField::email('email', 'Email', false),
            CrudField::textarea('address', 'Address', false, 3),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'tenant_id' => ['required', 'string', 'max:191'],
            'contact_type' => ['nullable', 'string', 'max:191'],
            'name' => ['required', 'string', 'max:191'],
            'relationship' => ['nullable', 'string', 'max:191'],
            'phone' => ['nullable', 'string', 'max:191'],
            'email' => ['nullable', 'email', 'max:191'],
            'address' => ['nullable', 'string'],
        ];
    }
}
