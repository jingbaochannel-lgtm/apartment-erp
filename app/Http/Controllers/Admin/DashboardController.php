<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApartmentProfile;
use App\Models\Invoice;
use App\Models\MaintenanceRequest;
use App\Models\RentalContract;
use App\Models\Room;
use App\Models\Tenant;

/**
 * Top-level admin dashboard. Builds a small bag of headline KPIs for
 * the welcome view — tenant counts, occupancy, outstanding invoices,
 * active branches.
 */
class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'branches' => ApartmentProfile::query()->withoutApartmentScope()->count(),
            'tenants' => Tenant::query()->count(),
            'rooms' => Room::query()->count(),
            'occupied_rooms' => Room::query()->where('status', 'occupied')->count(),
            'active_contracts' => RentalContract::query()->where('status', 'active')->count(),
            'unpaid_invoices' => Invoice::query()
                ->whereIn('status', ['unpaid', 'partial', 'overdue'])
                ->count(),
            'open_maintenance' => MaintenanceRequest::query()
                ->whereIn('status', ['pending', 'in_progress', 'open'])
                ->count(),
        ];

        return view('admin.dashboard.index', compact('stats'));
    }
}
