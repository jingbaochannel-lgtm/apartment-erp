<?php

namespace App\Http\Controllers\Admin;

use App\Models\PenaltyRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Penalty Rules.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class PenaltyRuleController extends BaseCrudController
{
    protected string $modelClass = PenaltyRule::class;
    protected string $routeSlug = 'penalty-rules';
    protected ?string $permissionModule = 'penalty_rules';
    protected string $singular = 'Penalty Rule';
    protected string $plural = 'Penalty Rules';
    protected array $with = [];
    protected array $searchable = ['rule_code', 'name'];
    protected array $columns = [
        'id' => '#',
        'rule_code' => 'Code',
        'name' => 'Name',
        'penalty_type' => 'Type',
        'rate_or_amount' => 'Rate/Amount',
        'grace_days' => 'Grace Days',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('rule_code', 'Code', true),
            \App\Support\CrudField::text('name', 'Name', true),
            \App\Support\CrudField::select('penalty_type', 'Type', ['fixed' => 'Fixed Amount', 'percentage' => 'Percentage', 'daily' => 'Daily'], false),
            \App\Support\CrudField::decimal('rate_or_amount', 'Rate / Amount', false),
            \App\Support\CrudField::number('grace_days', 'Grace Days', false),
            \App\Support\CrudField::decimal('maximum_penalty', 'Maximum Penalty', false),
            \App\Support\CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'rule_code' => ['required', 'string', 'max:191'],
            'name' => ['required', 'string', 'max:191'],
            'penalty_type' => ['nullable', 'string', 'max:191'],
            'rate_or_amount' => ['nullable', 'numeric'],
            'grace_days' => ['nullable', 'integer'],
            'maximum_penalty' => ['nullable', 'numeric'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}