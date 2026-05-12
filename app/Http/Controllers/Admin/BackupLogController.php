<?php

namespace App\Http\Controllers\Admin;

use App\Models\BackupLog;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Backup Logs.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class BackupLogController extends BaseCrudController
{
    protected string $modelClass = BackupLog::class;

    protected string $routeSlug = 'backup-logs';

    protected ?string $permissionModule = 'backup_logs';

    protected string $singular = 'Backup Log';

    protected string $plural = 'Backup Logs';

    protected array $with = [];

    protected array $searchable = ['backup_no', 'backup_type'];

    protected array $columns = [
        'id' => '#',
        'backup_no' => 'No.',
        'backup_type' => 'Type',
        'storage_location' => 'Location',
        'started_at' => 'Started',
        'completed_at' => 'Completed',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::text('backup_no', 'No.', true),
            CrudField::select('backup_type', 'Type', ['full' => 'Full', 'incremental' => 'Incremental', 'manual' => 'Manual'], false),
            CrudField::text('storage_location', 'Storage Location', false),
            CrudField::text('file_path', 'File Path', false),
            CrudField::number('file_size_bytes', 'File Size (bytes)', false),
            CrudField::datetime('started_at', 'Started At', false),
            CrudField::datetime('completed_at', 'Completed At', false),
            CrudField::datetime('restore_tested_at', 'Restore Tested At', false),
            CrudField::select('status', 'Status', ['running' => 'Running', 'completed' => 'Completed', 'failed' => 'Failed'], false),
            CrudField::textarea('error_message', 'Error Message', false, 3),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'backup_no' => ['required', 'string', 'max:191'],
            'backup_type' => ['nullable', 'string', 'max:191'],
            'storage_location' => ['nullable', 'string', 'max:191'],
            'file_path' => ['nullable', 'string', 'max:191'],
            'file_size_bytes' => ['nullable', 'integer'],
            'started_at' => ['nullable', 'date'],
            'completed_at' => ['nullable', 'date'],
            'restore_tested_at' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:191'],
            'error_message' => ['nullable', 'string'],
        ];
    }
}
