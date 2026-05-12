<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tenant;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Tenants.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class TenantController extends BaseCrudController
{
    protected string $modelClass = Tenant::class;

    protected string $routeSlug = 'tenants';

    protected ?string $permissionModule = 'tenants';

    protected string $singular = 'Tenant';

    protected string $plural = 'Tenants';

    protected array $with = [];

    protected array $searchable = ['tenant_code', 'full_name', 'phone', 'email', 'id_card_number'];

    protected array $columns = [
        'id' => '#',
        'tenant_code' => 'Code',
        'full_name' => 'Name',
        'phone' => 'Phone',
        'email' => 'Email',
        'occupation' => 'Occupation',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::text('tenant_code', 'Code', true),
            CrudField::text('full_name', 'Full Name', true),
            CrudField::select('gender', 'Gender', ['male' => 'Male', 'female' => 'Female', 'other' => 'Other'], false),
            CrudField::date('date_of_birth', 'Date of Birth', false),
            CrudField::text('phone', 'Phone', false),
            CrudField::email('email', 'Email', false),
            CrudField::textarea('address', 'Address', false, 3),
            CrudField::text('occupation', 'Occupation', false),
            CrudField::text('nationality', 'Nationality', false),
            CrudField::text('id_card_number', 'ID Card #', false),
            CrudField::text('passport_number', 'Passport #', false),
            CrudField::text('photo_path', 'Photo Path', false),
            CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'tenant_code' => ['required', 'string', 'max:191'],
            'full_name' => ['required', 'string', 'max:191'],
            'gender' => ['nullable', 'string', 'max:191'],
            'date_of_birth' => ['nullable', 'date'],
            'phone' => ['nullable', 'string', 'max:191'],
            'email' => ['nullable', 'email', 'max:191'],
            'address' => ['nullable', 'string'],
            'occupation' => ['nullable', 'string', 'max:191'],
            'nationality' => ['nullable', 'string', 'max:191'],
            'id_card_number' => ['nullable', 'string', 'max:191'],
            'passport_number' => ['nullable', 'string', 'max:191'],
            'photo_path' => ['nullable', 'string', 'max:191'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
