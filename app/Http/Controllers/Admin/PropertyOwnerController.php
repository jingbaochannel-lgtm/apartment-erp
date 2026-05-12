<?php

namespace App\Http\Controllers\Admin;

use App\Models\PropertyOwner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Property Owners.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class PropertyOwnerController extends BaseCrudController
{
    protected string $modelClass = PropertyOwner::class;
    protected string $routeSlug = 'property-owners';
    protected ?string $permissionModule = 'property_owners';
    protected string $singular = 'Property Owner';
    protected string $plural = 'Property Owners';
    protected array $with = [];
    protected array $searchable = ['owner_code', 'name', 'phone', 'email'];
    protected array $columns = [
        'id' => '#',
        'owner_code' => 'Code',
        'name' => 'Name',
        'phone' => 'Phone',
        'email' => 'Email',
        'ownership_percentage' => 'Ownership %',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('owner_code', 'Code', true),
            \App\Support\CrudField::text('name', 'Name', true),
            \App\Support\CrudField::text('phone', 'Phone', false),
            \App\Support\CrudField::email('email', 'Email', false),
            \App\Support\CrudField::textarea('address', 'Address', false, 3),
            \App\Support\CrudField::decimal('ownership_percentage', 'Ownership %', false),
            \App\Support\CrudField::text('bank_name', 'Bank Name', false),
            \App\Support\CrudField::text('bank_account_name', 'Account Name', false),
            \App\Support\CrudField::text('bank_account_number', 'Account Number', false),
            \App\Support\CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'owner_code' => ['required', 'string', 'max:191'],
            'name' => ['required', 'string', 'max:191'],
            'phone' => ['nullable', 'string', 'max:191'],
            'email' => ['nullable', 'email', 'max:191'],
            'address' => ['nullable', 'string'],
            'ownership_percentage' => ['nullable', 'numeric'],
            'bank_name' => ['nullable', 'string', 'max:191'],
            'bank_account_name' => ['nullable', 'string', 'max:191'],
            'bank_account_number' => ['nullable', 'string', 'max:191'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}