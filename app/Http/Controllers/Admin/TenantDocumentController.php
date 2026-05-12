<?php

namespace App\Http\Controllers\Admin;

use App\Models\TenantDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
            \App\Support\CrudField::select('tenant_id', 'Tenant', static::options(\App\Models\Tenant::class), true),
            \App\Support\CrudField::text('document_code', 'Code', false),
            \App\Support\CrudField::select('document_type', 'Type', ['id_card' => 'ID Card', 'passport' => 'Passport', 'driver_license' => 'Driver License', 'other' => 'Other'], false),
            \App\Support\CrudField::text('title', 'Title', true),
            \App\Support\CrudField::text('file_path', 'File Path', false),
            \App\Support\CrudField::date('issue_date', 'Issue Date', false),
            \App\Support\CrudField::date('expiry_date', 'Expiry Date', false),
            \App\Support\CrudField::checkbox('is_verified', 'Verified'),
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