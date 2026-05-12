<?php

namespace App\Http\Controllers\Admin;

use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Purchase Orders.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class PurchaseOrderController extends BaseCrudController
{
    protected string $modelClass = PurchaseOrder::class;
    protected string $routeSlug = 'purchase-orders';
    protected ?string $permissionModule = 'purchase_orders';
    protected string $singular = 'Purchase Order';
    protected string $plural = 'Purchase Orders';
    protected array $with = ['supplier'];
    protected array $searchable = ['po_no'];
    protected array $columns = [
        'id' => '#',
        'po_no' => 'No.',
        'supplier.supplier_name' => 'Supplier',
        'po_date' => 'Date',
        'total_amount' => 'Total',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('po_no', 'No.', true),
            \App\Support\CrudField::select('supplier_id', 'Supplier', static::options(\App\Models\Supplier::class), true),
            \App\Support\CrudField::date('po_date', 'Order Date', false),
            \App\Support\CrudField::date('expected_delivery_date', 'Expected Delivery', false),
            \App\Support\CrudField::decimal('total_amount', 'Total Amount', false),
            \App\Support\CrudField::select('status', 'Status', ['draft' => 'Draft', 'pending' => 'Pending', 'approved' => 'Approved', 'received' => 'Received', 'cancelled' => 'Cancelled'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'po_no' => ['required', 'string', 'max:191'],
            'supplier_id' => ['required', 'string', 'max:191'],
            'po_date' => ['nullable', 'date'],
            'expected_delivery_date' => ['nullable', 'date'],
            'total_amount' => ['nullable', 'numeric'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}