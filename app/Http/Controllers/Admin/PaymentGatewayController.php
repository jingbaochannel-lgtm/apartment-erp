<?php

namespace App\Http\Controllers\Admin;

use App\Models\PaymentGateway;
use App\Support\CrudField;
use Illuminate\Database\Eloquent\Model;

/**
 * Auto-generated CRUD controller for Payment Gateways.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class PaymentGatewayController extends BaseCrudController
{
    protected string $modelClass = PaymentGateway::class;

    protected string $routeSlug = 'payment-gateways';

    protected ?string $permissionModule = 'payment_gateways';

    protected string $singular = 'Payment Gateway';

    protected string $plural = 'Payment Gateways';

    protected array $with = [];

    protected array $searchable = ['gateway_code', 'gateway_name'];

    protected array $columns = [
        'id' => '#',
        'gateway_code' => 'Code',
        'gateway_name' => 'Name',
        'provider' => 'Provider',
        'sandbox_mode' => 'Sandbox',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            CrudField::text('gateway_code', 'Code', true),
            CrudField::text('gateway_name', 'Name', true),
            CrudField::select('provider', 'Provider', ['aba' => 'ABA Pay', 'wing' => 'Wing', 'pipay' => 'Pipay', 'bakong' => 'Bakong', 'stripe' => 'Stripe', 'other' => 'Other'], false),
            CrudField::textarea('configuration', 'Configuration (JSON)', false, 5),
            CrudField::checkbox('sandbox_mode', 'Sandbox'),
            CrudField::select('status', 'Status', ['active' => 'Active', 'inactive' => 'Inactive'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'gateway_code' => ['required', 'string', 'max:191'],
            'gateway_name' => ['required', 'string', 'max:191'],
            'provider' => ['nullable', 'string', 'max:191'],
            'configuration' => ['nullable', 'string'],
            'sandbox_mode' => ['nullable', 'boolean'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}
