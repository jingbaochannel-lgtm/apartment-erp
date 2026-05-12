<?php

namespace App\Http\Controllers\Admin;

use App\Models\LegalDocument;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Legal Documents.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class LegalDocumentController extends BaseCrudController
{
    protected string $modelClass = LegalDocument::class;

    protected string $routeSlug = 'legal-documents';

    protected ?string $permissionModule = 'legal_documents';

    protected string $singular = 'Legal Document';

    protected string $plural = 'Legal Documents';

    protected array $with = [];

    protected array $searchable = ['document_code', 'title', 'license_or_reference_no'];

    protected array $columns = [
        'id' => '#',
        'document_code' => 'Code',
        'document_type' => 'Type',
        'title' => 'Title',
        'expiry_date' => 'Expiry',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::text('document_code', 'Code', true),
            CrudField::select('document_type', 'Type', ['business_license' => 'Business License', 'permit' => 'Permit', 'tax_certificate' => 'Tax Certificate', 'insurance' => 'Insurance', 'other' => 'Other'], true),
            CrudField::text('title', 'Title', true),
            CrudField::text('license_or_reference_no', 'Reference No', false),
            CrudField::date('issue_date', 'Issue Date', false),
            CrudField::date('expiry_date', 'Expiry Date', false),
            CrudField::text('file_path', 'File Path', false),
            CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'document_code' => ['required', 'string', 'max:191'],
            'document_type' => ['required', 'string', 'max:191'],
            'title' => ['required', 'string', 'max:191'],
            'license_or_reference_no' => ['nullable', 'string', 'max:191'],
            'issue_date' => ['nullable', 'date'],
            'expiry_date' => ['nullable', 'date'],
            'file_path' => ['nullable', 'string', 'max:191'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
