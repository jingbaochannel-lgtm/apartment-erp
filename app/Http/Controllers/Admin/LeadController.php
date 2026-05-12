<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Leads.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class LeadController extends BaseCrudController
{
    protected string $modelClass = Lead::class;
    protected string $routeSlug = 'leads';
    protected ?string $permissionModule = 'leads';
    protected string $singular = 'Lead';
    protected string $plural = 'Leads';
    protected array $with = [];
    protected array $searchable = ['lead_no', 'name', 'phone'];
    protected array $columns = [
        'id' => '#',
        'lead_no' => 'No.',
        'name' => 'Name',
        'phone' => 'Phone',
        'source' => 'Source',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('lead_no', 'No.', true),
            \App\Support\CrudField::text('name', 'Name', true),
            \App\Support\CrudField::text('phone', 'Phone', false),
            \App\Support\CrudField::email('email', 'Email', false),
            \App\Support\CrudField::select('source', 'Source', ['walk_in' => 'Walk-in', 'website' => 'Website', 'referral' => 'Referral', 'agent' => 'Agent', 'social_media' => 'Social Media', 'other' => 'Other'], false),
            \App\Support\CrudField::select('room_id', 'Interested Room', static::options(\App\Models\Room::class), false),
            \App\Support\CrudField::date('appointment_date', 'Appointment', false),
            \App\Support\CrudField::textarea('interest_notes', 'Interest Notes', false, 3),
            \App\Support\CrudField::select('status', 'Status', ['new' => 'New', 'contacted' => 'Contacted', 'converted' => 'Converted', 'lost' => 'Lost'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'lead_no' => ['required', 'string', 'max:191'],
            'name' => ['required', 'string', 'max:191'],
            'phone' => ['nullable', 'string', 'max:191'],
            'email' => ['nullable', 'email', 'max:191'],
            'source' => ['nullable', 'string', 'max:191'],
            'room_id' => ['nullable', 'string', 'max:191'],
            'appointment_date' => ['nullable', 'date'],
            'interest_notes' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}