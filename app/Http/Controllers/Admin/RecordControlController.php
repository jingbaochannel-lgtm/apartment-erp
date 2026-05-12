<?php

namespace App\Http\Controllers\Admin;

use App\Models\RecordControl;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Record Controls.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class RecordControlController extends BaseCrudController
{
    protected string $modelClass = RecordControl::class;
    protected string $routeSlug = 'record-controls';
    protected ?string $permissionModule = 'record_controls';
    protected string $singular = 'Record Control';
    protected string $plural = 'Record Controls';
    protected array $with = [];
    protected array $searchable = ['record_code', 'record_type'];
    protected array $columns = [
        'id' => '#',
        'record_code' => 'Code',
        'record_type' => 'Type',
        'storage_location' => 'Location',
        'retention_period' => 'Retention',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('record_code', 'Code', true),
            \App\Support\CrudField::text('record_type', 'Type', false),
            \App\Support\CrudField::text('storage_location', 'Storage Location', false),
            \App\Support\CrudField::text('retention_period', 'Retention Period', false),
            \App\Support\CrudField::number('responsible_person_id', 'Responsible Person ID', false),
            \App\Support\CrudField::text('disposal_method', 'Disposal Method', false),
            \App\Support\CrudField::date('disposal_due_date', 'Disposal Due Date', false),
            \App\Support\CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'record_code' => ['required', 'string', 'max:191'],
            'record_type' => ['nullable', 'string', 'max:191'],
            'storage_location' => ['nullable', 'string', 'max:191'],
            'retention_period' => ['nullable', 'string', 'max:191'],
            'responsible_person_id' => ['nullable', 'integer'],
            'disposal_method' => ['nullable', 'string', 'max:191'],
            'disposal_due_date' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}