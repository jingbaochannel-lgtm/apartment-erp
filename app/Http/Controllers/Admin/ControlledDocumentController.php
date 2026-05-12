<?php

namespace App\Http\Controllers\Admin;

use App\Models\ControlledDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Controlled Documents.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class ControlledDocumentController extends BaseCrudController
{
    protected string $modelClass = ControlledDocument::class;
    protected string $routeSlug = 'controlled-documents';
    protected ?string $permissionModule = 'controlled_documents';
    protected string $singular = 'Controlled Document';
    protected string $plural = 'Controlled Documents';
    protected array $with = [];
    protected array $searchable = ['document_code', 'title'];
    protected array $columns = [
        'id' => '#',
        'document_code' => 'Code',
        'document_type' => 'Type',
        'title' => 'Title',
        'version_number' => 'Version',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('document_code', 'Code', true),
            \App\Support\CrudField::select('document_type', 'Type', ['policy' => 'Policy', 'procedure' => 'Procedure', 'form' => 'Form', 'manual' => 'Manual', 'other' => 'Other'], false),
            \App\Support\CrudField::text('title', 'Title', true),
            \App\Support\CrudField::text('version_number', 'Version', false),
            \App\Support\CrudField::date('effective_date', 'Effective Date', false),
            \App\Support\CrudField::text('prepared_by', 'Prepared By', false),
            \App\Support\CrudField::text('reviewed_by', 'Reviewed By', false),
            \App\Support\CrudField::text('approved_by', 'Approved By', false),
            \App\Support\CrudField::datetime('approved_at', 'Approved At', false),
            \App\Support\CrudField::text('file_path', 'File Path', false),
            \App\Support\CrudField::select('status', 'Status', ['draft' => 'Draft', 'active' => 'Active', 'obsolete' => 'Obsolete'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'document_code' => ['required', 'string', 'max:191'],
            'document_type' => ['nullable', 'string', 'max:191'],
            'title' => ['required', 'string', 'max:191'],
            'version_number' => ['nullable', 'string', 'max:191'],
            'effective_date' => ['nullable', 'date'],
            'prepared_by' => ['nullable', 'string', 'max:191'],
            'reviewed_by' => ['nullable', 'string', 'max:191'],
            'approved_by' => ['nullable', 'string', 'max:191'],
            'approved_at' => ['nullable', 'date'],
            'file_path' => ['nullable', 'string', 'max:191'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}