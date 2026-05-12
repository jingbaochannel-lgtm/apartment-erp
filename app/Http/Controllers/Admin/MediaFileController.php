<?php

namespace App\Http\Controllers\Admin;

use App\Models\MediaFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Media Files.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class MediaFileController extends BaseCrudController
{
    protected string $modelClass = MediaFile::class;
    protected string $routeSlug = 'media-files';
    protected ?string $permissionModule = 'media_files';
    protected string $singular = 'Media File';
    protected string $plural = 'Media Files';
    protected array $with = [];
    protected array $searchable = ['original_name', 'collection'];
    protected array $columns = [
        'id' => '#',
        'original_name' => 'Name',
        'collection' => 'Collection',
        'fileable_type' => 'Owner Type',
        'fileable_id' => 'Owner ID',
        'mime_type' => 'MIME',
        'size_bytes' => 'Size',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('original_name', 'Original Name', true),
            \App\Support\CrudField::text('file_name', 'File Name', false),
            \App\Support\CrudField::text('collection', 'Collection', false),
            \App\Support\CrudField::text('fileable_type', 'Owner Type', false),
            \App\Support\CrudField::number('fileable_id', 'Owner ID', false),
            \App\Support\CrudField::text('mime_type', 'MIME Type', false),
            \App\Support\CrudField::text('disk', 'Disk', false),
            \App\Support\CrudField::text('path', 'Path', false),
            \App\Support\CrudField::number('size_bytes', 'Size (bytes)', false),
            \App\Support\CrudField::text('uploaded_by', 'Uploaded By', false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'original_name' => ['required', 'string', 'max:191'],
            'file_name' => ['nullable', 'string', 'max:191'],
            'collection' => ['nullable', 'string', 'max:191'],
            'fileable_type' => ['nullable', 'string', 'max:191'],
            'fileable_id' => ['nullable', 'integer'],
            'mime_type' => ['nullable', 'string', 'max:191'],
            'disk' => ['nullable', 'string', 'max:191'],
            'path' => ['nullable', 'string', 'max:191'],
            'size_bytes' => ['nullable', 'integer'],
            'uploaded_by' => ['nullable', 'string', 'max:191'],
        ];
    }
}