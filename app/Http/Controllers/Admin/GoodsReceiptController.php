<?php

namespace App\Http\Controllers\Admin;

use App\Models\GoodsReceipt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for Goods Receipts.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class GoodsReceiptController extends BaseCrudController
{
    protected string $modelClass = GoodsReceipt::class;
    protected string $routeSlug = 'goods-receipts';
    protected ?string $permissionModule = 'goods_receipts';
    protected string $singular = 'Goods Receipt';
    protected string $plural = 'Goods Receipts';
    protected array $with = [];
    protected array $searchable = ['grn_no'];
    protected array $columns = [
        'id' => '#',
        'grn_no' => 'GRN No.',
        'received_date' => 'Date',
        'status' => 'Status',
    ];

    protected function fields(): array
    {
        return [
            \App\Support\CrudField::text('grn_no', 'GRN No.', true),
            \App\Support\CrudField::select('purchase_order_id', 'Purchase Order', static::options(\App\Models\PurchaseOrder::class), false),
            \App\Support\CrudField::date('received_date', 'Received Date', false),
            \App\Support\CrudField::text('received_by', 'Received By', false),
            \App\Support\CrudField::textarea('notes', 'Notes', false, 3),
            \App\Support\CrudField::select('status', 'Status', ['received' => 'Received', 'partial' => 'Partial', 'rejected' => 'Rejected'], false),
        ];
    }

    protected function rules(?Model $record = null): array
    {
        return [
            'grn_no' => ['required', 'string', 'max:191'],
            'purchase_order_id' => ['nullable', 'string', 'max:191'],
            'received_date' => ['nullable', 'date'],
            'received_by' => ['nullable', 'string', 'max:191'],
            'notes' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:191'],
        ];
    }
}