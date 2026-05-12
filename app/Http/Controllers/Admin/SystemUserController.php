<?php

namespace App\Http\Controllers\Admin;

use App\Models\SystemUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Users.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class SystemUserController extends BaseCrudController
{
    protected string $modelClass = SystemUser::class;
    protected string $routeSlug = 'system-users';
    protected ?string $permissionModule = 'system_users';
    protected string $singular = 'User';
    protected string $plural = 'Users';
    protected array $with = [];
    protected array $searchable = ['username', 'email', 'name'];
    protected array $columns = [
        'id' => '#',
        'name' => 'Name',
        'username' => 'Username',
        'email' => 'Email',
        'user_type' => 'Type',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('name', 'Name', true),
            \App\Support\CrudField::text('username', 'Username', true),
            \App\Support\CrudField::email('email', 'Email', true),
            \App\Support\CrudField::text('phone', 'Phone', false),
            \App\Support\CrudField::select('user_type', 'User Type', ['admin' => 'Admin', 'staff' => 'Staff', 'tenant' => 'Tenant'], false),
            \App\Support\CrudField::password('password', 'Password (leave blank to keep)', false),
            \App\Support\CrudField::select('staff_id', 'Linked Staff', static::options(\App\Models\Staff::class), false),
            \App\Support\CrudField::select('tenant_id', 'Linked Tenant', static::options(\App\Models\Tenant::class), false),
            \App\Support\CrudField::checkbox('two_factor_enabled', '2FA Enabled'),
            \App\Support\CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive', 'locked' => 'Locked'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'username' => ['required', 'string', 'max:191'],
            'email' => ['required', 'email', 'max:191'],
            'phone' => ['nullable', 'string', 'max:191'],
            'user_type' => ['nullable', 'string', 'max:191'],
            'password' => ['nullable', 'string', 'min:6'],
            'staff_id' => ['nullable', 'string', 'max:191'],
            'tenant_id' => ['nullable', 'string', 'max:191'],
            'two_factor_enabled' => ['nullable', 'boolean'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }

    protected function beforeSave(array $data, Request $request, ?\Illuminate\Database\Eloquent\Model $record = null): array
    {
        $password = $request->input("password"); if (! $password) { unset($data["password"]); } else { $data["password"] = bcrypt($password); }
        return $data;
    }
}