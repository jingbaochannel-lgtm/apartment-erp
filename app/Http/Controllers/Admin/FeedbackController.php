<?php

namespace App\Http\Controllers\Admin;

use App\Models\Feedback;
use App\Models\Room;
use App\Models\Tenant;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Feedback.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class FeedbackController extends BaseCrudController
{
    protected string $modelClass = Feedback::class;

    protected string $routeSlug = 'feedback';

    protected ?string $permissionModule = 'feedback';

    protected string $singular = 'Feedback';

    protected string $plural = 'Feedback';

    protected array $with = ['tenant', 'room'];

    protected array $searchable = [];

    protected array $columns = [
        'id' => '#',
        'tenant_id' => 'Tenant',
        'room_id' => 'Room',
        'rating' => 'Rating',
        'overall_satisfaction_score' => 'Overall',
        'feedback_date' => 'Date',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::select('tenant_id', 'Tenant', static::options(Tenant::class), false),
            CrudField::select('room_id', 'Room', static::options(Room::class), false),
            CrudField::number('rating', 'Rating (1-5)', false),
            CrudField::textarea('comment', 'Comment', false, 3),
            CrudField::number('service_quality_score', 'Service Quality (1-5)', false),
            CrudField::number('cleanliness_score', 'Cleanliness (1-5)', false),
            CrudField::number('security_score', 'Security (1-5)', false),
            CrudField::number('overall_satisfaction_score', 'Overall (1-5)', false),
            CrudField::date('feedback_date', 'Date', false),
            CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'tenant_id' => ['nullable', 'string', 'max:191'],
            'room_id' => ['nullable', 'string', 'max:191'],
            'rating' => ['nullable', 'integer'],
            'comment' => ['nullable', 'string'],
            'service_quality_score' => ['nullable', 'integer'],
            'cleanliness_score' => ['nullable', 'integer'],
            'security_score' => ['nullable', 'integer'],
            'overall_satisfaction_score' => ['nullable', 'integer'],
            'feedback_date' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
