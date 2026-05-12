<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

/* ----------------------------------------------------------------------
 | Root — bounce visitors straight into the admin dashboard. Auth flow is
 | wired separately under `routes/auth.php` (Laravel default scaffolding).
 *--------------------------------------------------------------------- */
Route::get('/', fn () => redirect()->route('admin.dashboard'));

/* ----------------------------------------------------------------------
 | Language switcher — POSTed by the navbar dropdown via jQuery AJAX.
 | The GET variant is a plain-URL fallback (e.g. `/language/km`) for
 | bookmarks or pre-login screens.
 *--------------------------------------------------------------------- */
Route::post('/language', [LanguageController::class, 'switch'])->name('language.set');
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.set.get');

/* ----------------------------------------------------------------------
 | Admin / branch-switch surface. The list of `$resources` mirrors
 | `scripts/controller_definitions.php` 1:1 — each entry produces a
 | full Laravel resource controller plus an extra `data` route that
 | feeds Yajra DataTables server-side payloads.
 *--------------------------------------------------------------------- */
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::post('/apartment-switch', [Admin\ApartmentSwitcherController::class, 'update'])
        ->name('apartment.switch.admin');

    $resources = [
        // Organisation
        'apartment-profiles' => Admin\ApartmentProfileController::class,
        'property-owners' => Admin\PropertyOwnerController::class,
        'legal-documents' => Admin\LegalDocumentController::class,
        'departments' => Admin\DepartmentController::class,

        // Tenants
        'tenants' => Admin\TenantController::class,
        'tenant-contacts' => Admin\TenantContactController::class,
        'tenant-documents' => Admin\TenantDocumentController::class,

        // Property
        'buildings' => Admin\BuildingController::class,
        'floors' => Admin\FloorController::class,
        'room-types' => Admin\RoomTypeController::class,
        'facilities' => Admin\FacilityController::class,
        'rooms' => Admin\RoomController::class,
        'assets' => Admin\AssetController::class,

        // Contracts / move in-out
        'reservations' => Admin\ReservationController::class,
        'rental-contracts' => Admin\RentalContractController::class,
        'contract-renewals' => Admin\ContractRenewalController::class,
        'contract-terminations' => Admin\ContractTerminationController::class,
        'move-in-records' => Admin\MoveInRecordController::class,
        'move-out-records' => Admin\MoveOutRecordController::class,

        // Utilities & services
        'utility-types' => Admin\UtilityTypeController::class,
        'utility-rates' => Admin\UtilityRateController::class,
        'utility-meters' => Admin\UtilityMeterController::class,
        'utility-readings' => Admin\UtilityReadingController::class,
        'service-fees' => Admin\ServiceFeeController::class,

        // Billing
        'invoices' => Admin\InvoiceController::class,
        'payments' => Admin\PaymentController::class,
        'receipts' => Admin\ReceiptController::class,
        'penalty-rules' => Admin\PenaltyRuleController::class,
        'debt-reminders' => Admin\DebtReminderController::class,
        'payment-gateways' => Admin\PaymentGatewayController::class,

        // Maintenance & cleaning
        'maintenance-requests' => Admin\MaintenanceRequestController::class,
        'preventive-maintenance-schedules' => Admin\PreventiveMaintenanceScheduleController::class,
        'cleaning-tasks' => Admin\CleaningTaskController::class,

        // Inventory & procurement
        'inventory-categories' => Admin\InventoryCategoryController::class,
        'inventory-items' => Admin\InventoryItemController::class,
        'suppliers' => Admin\SupplierController::class,
        'purchase-orders' => Admin\PurchaseOrderController::class,
        'goods-receipts' => Admin\GoodsReceiptController::class,
        'stock-movements' => Admin\StockMovementController::class,

        // HR
        'staff' => Admin\StaffController::class,
        'staff-attendances' => Admin\StaffAttendanceController::class,
        'payrolls' => Admin\PayrollController::class,
        'staff-documents' => Admin\StaffDocumentController::class,

        // Accounting
        'accounting-categories' => Admin\AccountingCategoryController::class,
        'accounting-transactions' => Admin\AccountingTransactionController::class,

        // Sales / marketing
        'leads' => Admin\LeadController::class,

        // ISO QMS
        'controlled-documents' => Admin\ControlledDocumentController::class,
        'record-controls' => Admin\RecordControlController::class,
        'complaints' => Admin\ComplaintController::class,
        'capa-actions' => Admin\CapaActionController::class,
        'feedback' => Admin\FeedbackController::class,

        // Notifications & files
        'notification-templates' => Admin\NotificationTemplateController::class,
        'notifications' => Admin\NotificationController::class,
        'media-files' => Admin\MediaFileController::class,

        // Reports
        'report-exports' => Admin\ReportExportController::class,

        // System / RBAC
        'system-roles' => Admin\SystemRoleController::class,
        'system-permissions' => Admin\SystemPermissionController::class,
        'system-users' => Admin\SystemUserController::class,
        'system-settings' => Admin\SystemSettingController::class,
        'audit-logs' => Admin\AuditLogController::class,
        'backup-logs' => Admin\BackupLogController::class,
    ];

    foreach ($resources as $slug => $controller) {
        Route::get("/{$slug}/data", [$controller, 'data'])->name("{$slug}.data");
        Route::resource($slug, $controller);
    }
});

/* ----------------------------------------------------------------------
 | Public-facing apartment switcher entry (used by the navbar form).
 *--------------------------------------------------------------------- */
Route::post('/apartment-switch', [Admin\ApartmentSwitcherController::class, 'update'])
    ->name('apartment.switch');
