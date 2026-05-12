<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tenant;
use App\Models\TenantDocument;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Tenant Documents.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class TenantDocumentController extends BaseCrudController
{
    protected string $modelClass = TenantDocument::class;

    protected string $routeSlug = 'tenant-documents';

    protected ?string $permissionModule = 'tenant_documents';

    protected string $singular = 'Tenant Document';

    protected string $plural = 'Tenant Documents';

    protected array $with = ['tenant'];

    protected array $searchable = ['document_code', 'title'];

    protected array $columns = [
        'id' => '#',
        'tenant.full_name' => 'Tenant',
        'document_type' => 'Type',
        'title' => 'Title',
        'expiry_date' => 'Expiry',
        'is_verified' => 'Verified',
    ];

    protected function fields(): array
    {
        return [
            CrudField::select('tenant_id', 'Tenant', static::options(Tenant::class), true),
            CrudField::text('document_code', 'Code', false),
            CrudField::select('document_type', 'Type', ['id_card' => 'ID Card', 'passport' => 'Passport', 'driver_license' => 'Driver License', 'other' => 'Other'], false),
            CrudField::text('title', 'Title', true),
            CrudField::text('file_path', 'File Path', false),
            CrudField::date('issue_date', 'Issue Date', false),
            CrudField::date('expiry_date', 'Expiry Date', false),
            CrudField::checkbox('is_verified', 'Verified'),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'tenant_id' => ['required', 'string', 'max:191'],
            'document_code' => ['nullable', 'string', 'max:191'],
            'document_type' => ['nullable', 'string', 'max:191'],
            'title' => ['required', 'string', 'max:191'],
            'file_path' => ['nullable', 'string', 'max:191'],
            'issue_date' => ['nullable', 'date'],
            'expiry_date' => ['nullable', 'date'],
            'is_verified' => ['nullable', 'boolean'],
        ];
    }
}
