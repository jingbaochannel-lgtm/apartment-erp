@php
    use Illuminate\Support\Facades\Route;

    /**
     * Compact helper: emit a sidebar `<li>` linking to a named route, but
     * only if that route is actually registered. Lets the sidebar tolerate
     * incomplete generation runs without breaking the page.
     */
    $link = static function (string $routeName, string $label, ?string $icon = null) {
        if (! Route::has($routeName)) {
            return '';
        }
        $url = route($routeName);
        $iconHtml = $icon
            ? '<i class="bi bi-'.e($icon).' me-1"></i>'
            : '<i class="bi bi-arrow-right-short"></i>';

        return '<li><a href="'.e($url).'">'.$iconHtml.e($label).'</a></li>';
    };

    /** Group rendered only if at least one child link is registered. */
    $group = static function (string $title, string $icon, array $items) {
        $children = collect($items)->filter()->implode('');
        if ($children === '') {
            return '';
        }

        return '<li><a href="javascript:;" class="has-arrow">'
            .'<div class="parent-icon"><i class="bi bi-'.e($icon).'"></i></div>'
            .'<div class="menu-title">'.e($title).'</div></a>'
            .'<ul>'.$children.'</ul></li>';
    };
@endphp

<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('assets/backend') }}/assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">{{ __('app.app_name') }}</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class="bi bi-chevron-double-left"></i></div>
    </div>

    <ul class="metismenu" id="menu">
        @if (Route::has('admin.dashboard'))
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <div class="parent-icon"><i class="bi bi-house-door"></i></div>
                    <div class="menu-title">{{ __('app.menu.dashboard') }}</div>
                </a>
            </li>
        @endif

        {{-- Organisation ------------------------------------------------- --}}
        {!! $group(__('app.menu.organisation'), 'building', [
            $link('admin.apartment-profiles.index', __('app.resources.apartment_profiles'), 'house-door'),
            $link('admin.property-owners.index', __('app.resources.property_owners'), 'person-badge'),
            $link('admin.departments.index', __('app.resources.departments'), 'diagram-3'),
        ]) !!}

        {{-- Property ----------------------------------------------------- --}}
        {!! $group(__('app.menu.property'), 'house-fill', [
            $link('admin.buildings.index', __('app.resources.buildings')),
            $link('admin.floors.index', __('app.resources.floors')),
            $link('admin.room-types.index', __('app.resources.room_types')),
            $link('admin.rooms.index', __('app.resources.rooms')),
            $link('admin.facilities.index', __('app.resources.facilities')),
            $link('admin.room-facilities.index', __('app.resources.room_facilities')),
            $link('admin.room-type-facilities.index', __('app.resources.room_type_facilities')),
            $link('admin.assets.index', __('app.resources.assets')),
            $link('admin.room-assets.index', __('app.resources.room_assets')),
        ]) !!}

        {{-- Tenants ------------------------------------------------------ --}}
        {!! $group(__('app.menu.tenants'), 'people', [
            $link('admin.tenants.index', __('app.resources.tenants')),
            $link('admin.tenant-contacts.index', __('app.resources.tenant_contacts')),
            $link('admin.tenant-documents.index', __('app.resources.tenant_documents')),
        ]) !!}

        {{-- Bookings & Contracts ---------------------------------------- --}}
        {!! $group(__('app.menu.contracts'), 'file-earmark-text', [
            $link('admin.reservations.index', __('app.resources.reservations')),
            $link('admin.rental-contracts.index', __('app.resources.rental_contracts')),
            $link('admin.contract-renewals.index', __('app.resources.contract_renewals')),
            $link('admin.contract-terminations.index', __('app.resources.contract_terminations')),
            $link('admin.move-in-records.index', __('app.resources.move_in_records')),
            $link('admin.move-out-records.index', __('app.resources.move_out_records')),
        ]) !!}

        {{-- Utilities & Services ---------------------------------------- --}}
        {!! $group(__('app.menu.utilities'), 'lightning-charge', [
            $link('admin.utility-types.index', __('app.resources.utility_types')),
            $link('admin.utility-meters.index', __('app.resources.utility_meters')),
            $link('admin.utility-readings.index', __('app.resources.utility_readings')),
            $link('admin.utility-rates.index', __('app.resources.utility_rates')),
            $link('admin.service-fees.index', __('app.resources.service_fees')),
            $link('admin.room-service-fees.index', __('app.resources.room_service_fees')),
        ]) !!}

        {{-- Billing ----------------------------------------------------- --}}
        {!! $group(__('app.menu.billing'), 'receipt', [
            $link('admin.invoices.index', __('app.resources.invoices')),
            $link('admin.invoice-items.index', __('app.resources.invoice_items')),
            $link('admin.payments.index', __('app.resources.payments')),
            $link('admin.receipts.index', __('app.resources.receipts')),
            $link('admin.payment-allocations.index', __('app.resources.payment_allocations')),
            $link('admin.payment-gateways.index', __('app.resources.payment_gateways')),
            $link('admin.penalty-rules.index', __('app.resources.penalty_rules')),
            $link('admin.debt-reminders.index', __('app.resources.debt_reminders')),
        ]) !!}

        {{-- Maintenance ------------------------------------------------- --}}
        {!! $group(__('app.menu.maintenance'), 'tools', [
            $link('admin.maintenance-requests.index', __('app.resources.maintenance_requests')),
            $link('admin.maintenance-updates.index', __('app.resources.maintenance_updates')),
            $link('admin.preventive-maintenance-schedules.index', __('app.resources.preventive_maintenance_schedules')),
            $link('admin.cleaning-tasks.index', __('app.resources.cleaning_tasks')),
            $link('admin.cleaning-checklist-items.index', __('app.resources.cleaning_checklist_items')),
        ]) !!}

        {{-- Inventory --------------------------------------------------- --}}
        {!! $group(__('app.menu.inventory'), 'box-seam', [
            $link('admin.inventory-categories.index', __('app.resources.inventory_categories')),
            $link('admin.inventory-items.index', __('app.resources.inventory_items')),
            $link('admin.stock-movements.index', __('app.resources.stock_movements')),
            $link('admin.suppliers.index', __('app.resources.suppliers')),
            $link('admin.purchase-orders.index', __('app.resources.purchase_orders')),
            $link('admin.purchase-order-items.index', __('app.resources.purchase_order_items')),
            $link('admin.goods-receipts.index', __('app.resources.goods_receipts')),
            $link('admin.goods-receipt-items.index', __('app.resources.goods_receipt_items')),
        ]) !!}

        {{-- HR ---------------------------------------------------------- --}}
        {!! $group(__('app.menu.hr'), 'person-workspace', [
            $link('admin.staff.index', __('app.resources.staff')),
            $link('admin.staff-documents.index', __('app.resources.staff_documents')),
            $link('admin.staff-attendances.index', __('app.resources.staff_attendances')),
            $link('admin.payrolls.index', __('app.resources.payrolls')),
            $link('admin.payroll-items.index', __('app.resources.payroll_items')),
        ]) !!}

        {{-- Accounting -------------------------------------------------- --}}
        {!! $group(__('app.menu.accounting'), 'cash-coin', [
            $link('admin.accounting-categories.index', __('app.resources.accounting_categories')),
            $link('admin.accounting-transactions.index', __('app.resources.accounting_transactions')),
        ]) !!}

        {{-- Sales & Marketing ------------------------------------------ --}}
        {!! $group(__('app.menu.sales'), 'megaphone', [
            $link('admin.leads.index', __('app.resources.leads')),
            $link('admin.lead-followups.index', __('app.resources.lead_followups')),
            $link('admin.feedback.index', __('app.resources.feedback')),
        ]) !!}

        {{-- ISO QMS ----------------------------------------------------- --}}
        {!! $group(__('app.menu.qms'), 'award', [
            $link('admin.controlled-documents.index', __('app.resources.controlled_documents')),
            $link('admin.controlled-document-revisions.index', __('app.resources.controlled_document_revisions')),
            $link('admin.record-controls.index', __('app.resources.record_controls')),
            $link('admin.complaints.index', __('app.resources.complaints')),
            $link('admin.capa-actions.index', __('app.resources.capa_actions')),
            $link('admin.legal-documents.index', __('app.resources.legal_documents')),
        ]) !!}

        {{-- Notifications ---------------------------------------------- --}}
        {!! $group(__('app.menu.notifications'), 'bell', [
            $link('admin.notification-templates.index', __('app.resources.notification_templates')),
            $link('admin.notifications.index', __('app.resources.notifications')),
            $link('admin.media-files.index', __('app.resources.media_files')),
        ]) !!}

        {{-- Reports ----------------------------------------------------- --}}
        {!! $group(__('app.menu.reports'), 'graph-up', [
            $link('admin.report-exports.index', __('app.resources.report_exports')),
        ]) !!}

        {{-- System ------------------------------------------------------ --}}
        {!! $group(__('app.menu.system'), 'gear', [
            $link('admin.system-users.index', __('app.resources.system_users')),
            $link('admin.system-roles.index', __('app.resources.system_roles')),
            $link('admin.system-permissions.index', __('app.resources.system_permissions')),
            $link('admin.user-roles.index', __('app.resources.user_roles')),
            $link('admin.role-permissions.index', __('app.resources.role_permissions')),
            $link('admin.user-permissions.index', __('app.resources.user_permissions')),
            $link('admin.system-settings.index', __('app.resources.system_settings')),
            $link('admin.audit-logs.index', __('app.resources.audit_logs')),
            $link('admin.backup-logs.index', __('app.resources.backup_logs')),
        ]) !!}
    </ul>
</aside>
