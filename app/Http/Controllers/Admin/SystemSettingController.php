<?php

namespace App\Http\Controllers\Admin;

use App\Models\SystemSetting;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

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
            CrudField::text('setting_group', 'Group', true),
            CrudField::text('setting_key', 'Key', true),
            CrudField::textarea('setting_value', 'Value', false, 3),
            CrudField::select('value_type', 'Value Type', ['string' => 'String', 'integer' => 'Integer', 'boolean' => 'Boolean', 'json' => 'JSON'], false),
            CrudField::checkbox('is_encrypted', 'Encrypted'),
            CrudField::textarea('description', 'Description', false, 3),
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
