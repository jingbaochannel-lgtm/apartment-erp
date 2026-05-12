<?php

namespace App\Http\Controllers\Admin;

use App\Models\ReportExport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Report Exports.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class ReportExportController extends BaseCrudController
{
    protected string $modelClass = ReportExport::class;
    protected string $routeSlug = 'report-exports';
    protected ?string $permissionModule = 'report_exports';
    protected string $singular = 'Report Export';
    protected string $plural = 'Report Exports';
    protected array $with = [];
    protected array $searchable = ['export_no', 'report_type'];
    protected array $columns = [
        'id' => '#',
        'export_no' => 'No.',
        'report_type' => 'Type',
        'format' => 'Format',
        'requested_at' => 'Requested',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('export_no', 'No.', true),
            \App\Support\CrudField::text('report_type', 'Report Type', false),
            \App\Support\CrudField::textarea('filters', 'Filters (JSON)', false, 3),
            \App\Support\CrudField::select('format', 'Format', ['pdf' => 'PDF', 'excel' => 'Excel', 'csv' => 'CSV'], false),
            \App\Support\CrudField::text('file_path', 'File Path', false),
            \App\Support\CrudField::text('requested_by', 'Requested By', false),
            \App\Support\CrudField::datetime('requested_at', 'Requested At', false),
            \App\Support\CrudField::datetime('completed_at', 'Completed At', false),
            \App\Support\CrudField::select('status', 'Status', ['queued' => 'Queued', 'processing' => 'Processing', 'completed' => 'Completed', 'failed' => 'Failed'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'export_no' => ['required', 'string', 'max:191'],
            'report_type' => ['nullable', 'string', 'max:191'],
            'filters' => ['nullable', 'string'],
            'format' => ['nullable', 'string', 'max:191'],
            'file_path' => ['nullable', 'string', 'max:191'],
            'requested_by' => ['nullable', 'string', 'max:191'],
            'requested_at' => ['nullable', 'date'],
            'completed_at' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}