<?php

namespace App\Http\Controllers\Admin;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Audit Logs.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class AuditLogController extends BaseCrudController
{
    protected string $modelClass = AuditLog::class;
    protected string $routeSlug = 'audit-logs';
    protected ?string $permissionModule = 'audit_logs';
    protected string $singular = 'Audit Log';
    protected string $plural = 'Audit Logs';
    protected array $with = [];
    protected array $searchable = ['module', 'action'];
    protected array $columns = [
        'id' => '#',
        'user_id' => 'User',
        'module' => 'Module',
        'action' => 'Action',
        'auditable_type' => 'Auditable',
        'auditable_id' => 'ID',
        'performed_at' => 'When',
    ];

    protected bool $readOnly = true;

    protected function fields(): array
    {
        return [];
    }

    protected function rules(?Model $record = null): array
    {
        return [
        ];
    }
}