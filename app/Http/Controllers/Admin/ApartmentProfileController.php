<?php

namespace App\Http\Controllers\Admin;

use App\Models\ApartmentProfile;
use App\Models\PropertyOwner;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Branches / Apartments.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class ApartmentProfileController extends BaseCrudController
{
    protected string $modelClass = ApartmentProfile::class;

    protected string $routeSlug = 'apartment-profiles';

    protected ?string $permissionModule = 'apartment_profiles';

    protected string $singular = 'Branch / Apartment';

    protected string $plural = 'Branches / Apartments';

    protected array $with = ['propertyOwner'];

    protected array $searchable = ['apartment_code', 'name', 'phone', 'email'];

    protected array $columns = [
        'id' => '#',
        'apartment_code' => 'Code',
        'name' => 'Name',
        'propertyOwner.name' => 'Owner',
        'phone' => 'Phone',
        'currency' => 'Currency',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::select('property_owner_id', 'Property Owner', static::options(PropertyOwner::class), false),
            CrudField::text('apartment_code', 'Code', true),
            CrudField::text('name', 'Name', true),
            CrudField::text('logo_path', 'Logo Path', false),
            CrudField::textarea('address', 'Address', false, 3),
            CrudField::text('phone', 'Phone', false),
            CrudField::email('email', 'Email', false),
            CrudField::text('website', 'Website', false),
            CrudField::text('tax_identification_number', 'Tax ID', false),
            CrudField::text('business_license_number', 'Business Licence', false),
            CrudField::text('currency', 'Currency', false),
            CrudField::text('timezone', 'Timezone', false),
            CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'property_owner_id' => ['nullable', 'string', 'max:191'],
            'apartment_code' => ['required', 'string', 'max:191'],
            'name' => ['required', 'string', 'max:191'],
            'logo_path' => ['nullable', 'string', 'max:191'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:191'],
            'email' => ['nullable', 'email', 'max:191'],
            'website' => ['nullable', 'string', 'max:191'],
            'tax_identification_number' => ['nullable', 'string', 'max:191'],
            'business_license_number' => ['nullable', 'string', 'max:191'],
            'currency' => ['nullable', 'string', 'max:191'],
            'timezone' => ['nullable', 'string', 'max:191'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
