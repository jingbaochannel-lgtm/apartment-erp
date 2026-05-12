<?php

namespace App\Http\Controllers\Admin;

use App\Models\SystemSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for System Settings.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class SystemSettingController extends BaseCrudController
{
    protected string $modelClass = SystemSetting::class;
    protected string $routeSlug = 'system-settings';
    protected ?string $permissionModule = 'system_settings';
    protected string $singular = 'System Setting';
    protected string $plural = 'System Settings';
    protected array $with = [];
    protected array $searchable = ['setting_group', 'setting_key'];
    protected array $columns = [
        'id' => '#',
        'setting_group' => 'Group',
        'setting_key' => 'Key',
        'setting_value' => 'Value',
        'value_type' => 'Type',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('setting_group', 'Group', true),
            \App\Support\CrudField::text('setting_key', 'Key', true),
            \App\Support\CrudField::textarea('setting_value', 'Value', false, 3),
            \App\Support\CrudField::select('value_type', 'Value Type', ['string' => 'String', 'integer' => 'Integer', 'boolean' => 'Boolean', 'json' => 'JSON'], false),
            \App\Support\CrudField::checkbox('is_encrypted', 'Encrypted'),
            \App\Support\CrudField::textarea('description', 'Description', false, 3),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'setting_group' => ['required', 'string', 'max:191'],
            'setting_key' => ['required', 'string', 'max:191'],
            'setting_value' => ['nullable', 'string'],
            'value_type' => ['nullable', 'string', 'max:191'],
            'is_encrypted' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
        ];
    }
}