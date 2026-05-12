<?php

namespace App\Http\Controllers\Admin;

use App\Models\Staff;
use App\Models\StaffDocument;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Staff Documents.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class StaffDocumentController extends BaseCrudController
{
    protected string $modelClass = StaffDocument::class;

    protected string $routeSlug = 'staff-documents';

    protected ?string $permissionModule = 'staff_documents';

    protected string $singular = 'Staff Document';

    protected string $plural = 'Staff Documents';

    protected array $with = [];

    protected array $searchable = ['document_code', 'title'];

    protected array $columns = [
        'id' => '#',
        'document_code' => 'Code',
        'document_type' => 'Type',
        'title' => 'Title',
        'expiry_date' => 'Expiry',
    ];

    protected function fields(): array
    {
        return [
            CrudField::select('staff_id', 'Staff', static::options(Staff::class), true),
            CrudField::text('document_code', 'Code', false),
            CrudField::text('document_type', 'Type', false),
            CrudField::text('title', 'Title', true),
            CrudField::text('file_path', 'File Path', false),
            CrudField::date('expiry_date', 'Expiry Date', false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'staff_id' => ['required', 'string', 'max:191'],
            'document_code' => ['nullable', 'string', 'max:191'],
            'document_type' => ['nullable', 'string', 'max:191'],
            'title' => ['required', 'string', 'max:191'],
            'file_path' => ['nullable', 'string', 'max:191'],
            'expiry_date' => ['nullable', 'date'],
        ];
    }
}
