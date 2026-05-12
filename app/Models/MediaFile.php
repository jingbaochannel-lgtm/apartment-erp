<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaFile extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'media_files';

    protected $fillable = [
        'collection',
        'created_by',
        'custom_properties',
        'deleted_by',
        'disk',
        'file_name',
        'fileable_id',
        'fileable_type',
        'metadata',
        'mime_type',
        'original_name',
        'path',
        'size_bytes',
        'updated_by',
        'uploaded_by',
    ];

    protected $casts = [
        'custom_properties' => 'array',
        'metadata' => 'array',
    ];
}
