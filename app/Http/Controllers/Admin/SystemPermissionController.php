<?php

namespace App\Http\Controllers\Admin;

use App\Models\SystemPermission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Permissions.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class SystemPermissionController extends BaseCrudController
{
    protected string $modelClass = SystemPermission::class;
    protected string $routeSlug = 'system-permissions';
    protected ?string $permissionModule = 'system_permissions';
    protected string $singular = 'Permission';
    protected string $plural = 'Permissions';
    protected array $with = [];
    protected array $searchable = ['permission_code', 'module', 'action'];
    protected array $columns = [
        'id' => '#',
        'permission_code' => 'Code',
        'module' => 'Module',
        'action' => 'Action',
        'name' => 'Name',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('permission_code', 'Code', true),
            \App\Support\CrudField::text('module', 'Module', true),
            \App\Support\CrudField::text('action', 'Action', true),
            \App\Support\CrudField::text('name', 'Name', true),
            \App\Support\CrudField::textarea('description', 'Description', false, 3),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'permission_code' => ['required', 'string', 'max:191'],
            'module' => ['required', 'string', 'max:191'],
            'action' => ['required', 'string', 'max:191'],
            'name' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string'],
        ];
    }
}