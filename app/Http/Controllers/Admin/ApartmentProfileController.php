<?php

namespace App\Http\Controllers\Admin;

use App\Models\ApartmentProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
            \App\Support\CrudField::select('property_owner_id', 'Property Owner', static::options(\App\Models\PropertyOwner::class), false),
            \App\Support\CrudField::text('apartment_code', 'Code', true),
            \App\Support\CrudField::text('name', 'Name', true),
            \App\Support\CrudField::text('logo_path', 'Logo Path', false),
            \App\Support\CrudField::textarea('address', 'Address', false, 3),
            \App\Support\CrudField::text('phone', 'Phone', false),
            \App\Support\CrudField::email('email', 'Email', false),
            \App\Support\CrudField::text('website', 'Website', false),
            \App\Support\CrudField::text('tax_identification_number', 'Tax ID', false),
            \App\Support\CrudField::text('business_license_number', 'Business Licence', false),
            \App\Support\CrudField::text('currency', 'Currency', false),
            \App\Support\CrudField::text('timezone', 'Timezone', false),
            \App\Support\CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
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