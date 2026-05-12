<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Apartment ERP Management System - All-in-one database migration.
     *
     * Target stack: PHP 8.4, Laravel, MySQL 8.4/InnoDB, utf8mb4.
     * This migration covers the core schema for apartments, buildings, floors,
     * rooms, tenants, contracts, move-in/out, booking, utilities, invoicing,
     * payments, debt/AR, maintenance, cleaning, inventory, procurement, HR,
     * accounting, tenant portal, leads, ISO document/record control, complaints,
     * CAPA, reports, notifications, RBAC, audit logs, settings, and backups.
     */
    public function up(): void
    {
        Schema::defaultStringLength(191);

        Schema::create('property_owners', function (Blueprint $table) {
            $table->id();
            $table->string('owner_code')->unique();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->index();
            $table->text('address')->nullable();
            $table->decimal('ownership_percentage', 5, 2)->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('apartment_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_owner_id')->nullable()->constrained('property_owners')->nullOnDelete();
            $table->string('apartment_code')->unique();
            $table->string('name');
            $table->string('logo_path')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('tax_identification_number')->nullable();
            $table->string('business_license_number')->nullable();
            $table->string('stamp_path')->nullable();
            $table->string('signature_path')->nullable();
            $table->string('currency', 10)->default('USD');
            $table->string('timezone')->default('Asia/Phnom_Penh');
            $table->string('status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('legal_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartment_profile_id')->constrained('apartment_profiles')->cascadeOnDelete();
            $table->string('document_code')->unique();
            $table->string('document_type')->index();
            $table->string('title');
            $table->string('license_or_reference_no')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable()->index();
            $table->string('file_path')->nullable();
            $table->string('status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartment_profile_id')->nullable()->constrained('apartment_profiles')->nullOnDelete();
            $table->string('department_code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartment_profile_id')->nullable()->constrained('apartment_profiles')->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->string('staff_code')->unique();
            $table->string('full_name');
            $table->string('position')->nullable()->index();
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->unique();
            $table->text('address')->nullable();
            $table->date('hire_date')->nullable();
            $table->decimal('basic_salary', 15, 2)->default(0);
            $table->string('employment_status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartment_profile_id')->nullable()->constrained('apartment_profiles')->nullOnDelete();
            $table->string('tenant_code')->unique();
            $table->string('full_name');
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone')->nullable()->index();
            $table->string('email')->nullable()->index();
            $table->text('address')->nullable();
            $table->string('occupation')->nullable();
            $table->string('nationality')->nullable();
            $table->string('id_card_number')->nullable()->index();
            $table->string('passport_number')->nullable()->index();
            $table->string('photo_path')->nullable();
            $table->string('status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('tenant_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('contact_type')->default('emergency')->index();
            $table->string('name');
            $table->string('relationship')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('system_roles', function (Blueprint $table) {
            $table->id();
            $table->string('role_code')->unique();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_system')->default(false);
            $table->string('status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('system_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('permission_code')->unique();
            $table->string('module')->index();
            $table->string('action')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unique(['module', 'action']);
            $this->timestampColumns($table);
        });

        Schema::create('system_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->string('user_type')->default('staff')->index();
            $table->boolean('two_factor_enabled')->default(false);
            $table->string('two_factor_secret')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->integer('failed_login_attempts')->default(0);
            $table->timestamp('locked_until')->nullable();
            $table->rememberToken();
            $table->string('status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('role_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('system_roles')->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained('system_permissions')->cascadeOnDelete();
            $table->unique(['role_id', 'permission_id']);
            $this->timestampColumns($table);
        });

        Schema::create('user_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('system_users')->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('system_roles')->cascadeOnDelete();
            $table->unique(['user_id', 'role_id']);
            $this->timestampColumns($table);
        });

        Schema::create('user_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('system_users')->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained('system_permissions')->cascadeOnDelete();
            $table->boolean('allowed')->default(true);
            $table->unique(['user_id', 'permission_id']);
            $this->timestampColumns($table);
        });

        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartment_profile_id')->constrained('apartment_profiles')->cascadeOnDelete();
            $table->foreignId('manager_staff_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->string('building_code');
            $table->string('name');
            $table->text('location')->nullable();
            $table->unsignedInteger('total_floors')->default(0);
            $table->unsignedInteger('total_rooms')->default(0);
            $table->string('status')->default('active')->index();
            $table->unique(['apartment_profile_id', 'building_code']);
            $this->commonColumns($table);
        });

        Schema::create('floors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained('buildings')->cascadeOnDelete();
            $table->string('floor_code');
            $table->string('floor_number')->index();
            $table->unsignedInteger('room_count')->default(0);
            $table->string('floor_map_path')->nullable();
            $table->string('status')->default('active')->index();
            $table->text('notes')->nullable();
            $table->unique(['building_id', 'floor_code']);
            $this->commonColumns($table);
        });

        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartment_profile_id')->nullable()->constrained('apartment_profiles')->nullOnDelete();
            $table->string('type_code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('default_monthly_rent', 15, 2)->default(0);
            $table->decimal('default_deposit_amount', 15, 2)->default(0);
            $table->unsignedInteger('default_capacity')->nullable();
            $table->string('status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('facility_code')->unique();
            $table->string('name');
            $table->string('category')->nullable()->index();
            $table->text('description')->nullable();
            $table->string('status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('room_type_facility', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_type_id')->constrained('room_types')->cascadeOnDelete();
            $table->foreignId('facility_id')->constrained('facilities')->cascadeOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->unique(['room_type_id', 'facility_id']);
            $this->timestampColumns($table);
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained('buildings')->cascadeOnDelete();
            $table->foreignId('floor_id')->constrained('floors')->cascadeOnDelete();
            $table->foreignId('room_type_id')->nullable()->constrained('room_types')->nullOnDelete();
            $table->string('room_code')->unique();
            $table->string('room_number')->index();
            $table->decimal('size_sqm', 10, 2)->nullable();
            $table->unsignedInteger('capacity')->nullable();
            $table->decimal('monthly_rent', 15, 2)->default(0);
            $table->decimal('deposit_amount', 15, 2)->default(0);
            $table->string('status')->default('available')->index();
            $table->text('description')->nullable();
            $table->json('gallery_paths')->nullable();
            $table->unique(['floor_id', 'room_number']);
            $this->commonColumns($table);
        });

        Schema::create('room_facility', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->foreignId('facility_id')->constrained('facilities')->cascadeOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->string('condition')->nullable();
            $table->text('notes')->nullable();
            $table->unique(['room_id', 'facility_id']);
            $this->timestampColumns($table);
        });

        Schema::create('tenant_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('document_code')->unique();
            $table->string('document_type')->index();
            $table->string('title');
            $table->string('file_path');
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable()->index();
            $table->boolean('is_verified')->default(false);
            $table->foreignId('verified_by')->nullable()->constrained('system_users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->string('reservation_no')->unique();
            $table->string('customer_name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->date('planned_move_in_date')->nullable();
            $table->decimal('deposit_amount', 15, 2)->default(0);
            $table->date('deposit_paid_date')->nullable();
            $table->string('status')->default('pending')->index();
            $table->text('notes')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('rental_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->foreignId('reservation_id')->nullable()->constrained('reservations')->nullOnDelete();
            $table->string('contract_no')->unique();
            $table->date('start_date')->index();
            $table->date('end_date')->nullable()->index();
            $table->decimal('monthly_rent', 15, 2)->default(0);
            $table->decimal('deposit_amount', 15, 2)->default(0);
            $table->unsignedTinyInteger('payment_due_day')->default(1);
            $table->text('terms_conditions')->nullable();
            $table->string('signed_contract_path')->nullable();
            $table->date('signed_date')->nullable();
            $table->string('status')->default('draft')->index();
            $this->commonColumns($table);
        });

        Schema::create('contract_renewals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('rental_contracts')->cascadeOnDelete();
            $table->string('renewal_no')->unique();
            $table->date('old_end_date')->nullable();
            $table->date('new_start_date');
            $table->date('new_end_date')->nullable();
            $table->decimal('old_monthly_rent', 15, 2)->default(0);
            $table->decimal('new_monthly_rent', 15, 2)->default(0);
            $table->decimal('old_deposit_amount', 15, 2)->default(0);
            $table->decimal('new_deposit_amount', 15, 2)->default(0);
            $table->string('renewal_document_path')->nullable();
            $table->string('status')->default('approved')->index();
            $this->commonColumns($table);
        });

        Schema::create('contract_terminations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('rental_contracts')->cascadeOnDelete();
            $table->string('termination_no')->unique();
            $table->date('termination_date')->index();
            $table->text('reason')->nullable();
            $table->decimal('outstanding_balance', 15, 2)->default(0);
            $table->decimal('deposit_deduction', 15, 2)->default(0);
            $table->decimal('deposit_refund', 15, 2)->default(0);
            $table->string('termination_letter_path')->nullable();
            $table->string('status')->default('draft')->index();
            $this->commonColumns($table);
        });

        Schema::create('move_in_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('rental_contracts')->cascadeOnDelete();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->string('move_in_no')->unique();
            $table->date('move_in_date')->index();
            $table->text('room_condition')->nullable();
            $table->text('facility_condition')->nullable();
            $table->decimal('water_meter_reading', 15, 3)->nullable();
            $table->decimal('electric_meter_reading', 15, 3)->nullable();
            $table->json('photo_paths')->nullable();
            $table->string('tenant_signature_path')->nullable();
            $table->string('status')->default('completed')->index();
            $this->commonColumns($table);
        });

        Schema::create('move_out_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('rental_contracts')->cascadeOnDelete();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->string('move_out_no')->unique();
            $table->date('move_out_date')->index();
            $table->text('room_condition')->nullable();
            $table->text('damaged_items')->nullable();
            $table->decimal('final_water_meter_reading', 15, 3)->nullable();
            $table->decimal('final_electric_meter_reading', 15, 3)->nullable();
            $table->decimal('outstanding_balance', 15, 2)->default(0);
            $table->decimal('damage_deduction', 15, 2)->default(0);
            $table->decimal('deposit_refund', 15, 2)->default(0);
            $table->json('photo_paths')->nullable();
            $table->string('tenant_signature_path')->nullable();
            $table->string('status')->default('draft')->index();
            $this->commonColumns($table);
        });

        Schema::create('utility_types', function (Blueprint $table) {
            $table->id();
            $table->string('utility_code')->unique();
            $table->string('name');
            $table->string('unit')->nullable();
            $table->string('billing_method')->default('meter')->index();
            $table->string('status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('utility_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utility_type_id')->constrained('utility_types')->cascadeOnDelete();
            $table->decimal('price_per_unit', 15, 4)->default(0);
            $table->decimal('minimum_charge', 15, 2)->default(0);
            $table->date('effective_from')->index();
            $table->date('effective_to')->nullable()->index();
            $table->string('status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('utility_meters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->foreignId('utility_type_id')->constrained('utility_types')->cascadeOnDelete();
            $table->string('meter_no')->nullable();
            $table->decimal('initial_reading', 15, 3)->default(0);
            $table->date('installed_date')->nullable();
            $table->string('status')->default('active')->index();
            $table->unique(['room_id', 'utility_type_id', 'meter_no']);
            $this->commonColumns($table);
        });

        Schema::create('utility_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utility_meter_id')->constrained('utility_meters')->cascadeOnDelete();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->foreignId('contract_id')->nullable()->constrained('rental_contracts')->nullOnDelete();
            $table->string('reading_no')->unique();
            $table->date('reading_date')->index();
            $table->string('billing_month', 7)->index();
            $table->decimal('old_reading', 15, 3)->default(0);
            $table->decimal('new_reading', 15, 3)->default(0);
            $table->decimal('usage_unit', 15, 3)->default(0);
            $table->decimal('price_per_unit', 15, 4)->default(0);
            $table->decimal('total_fee', 15, 2)->default(0);
            $table->string('status')->default('pending')->index();
            $this->commonColumns($table);
        });

        Schema::create('service_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartment_profile_id')->nullable()->constrained('apartment_profiles')->nullOnDelete();
            $table->string('service_code')->unique();
            $table->string('name');
            $table->string('fee_type')->default('monthly')->index();
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('room_service_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->foreignId('service_fee_id')->constrained('service_fees')->cascadeOnDelete();
            $table->decimal('amount', 15, 2)->default(0);
            $table->date('effective_from')->nullable();
            $table->date('effective_to')->nullable();
            $table->unique(['room_id', 'service_fee_id']);
            $this->timestampColumns($table);
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->foreignId('contract_id')->nullable()->constrained('rental_contracts')->nullOnDelete();
            $table->string('invoice_no')->unique();
            $table->string('billing_month', 7)->index();
            $table->date('invoice_date')->index();
            $table->date('due_date')->index();
            $table->decimal('room_fee', 15, 2)->default(0);
            $table->decimal('water_fee', 15, 2)->default(0);
            $table->decimal('electricity_fee', 15, 2)->default(0);
            $table->decimal('service_fee', 15, 2)->default(0);
            $table->decimal('old_balance', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('penalty', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('balance_due', 15, 2)->default(0);
            $table->string('pdf_path')->nullable();
            $table->string('status')->default('draft')->index();
            $this->commonColumns($table);
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();
            $table->string('item_type')->index();
            $table->string('description');
            $table->decimal('quantity', 15, 3)->default(1);
            $table->decimal('unit_price', 15, 4)->default(0);
            $table->decimal('amount', 15, 2)->default(0);
            $table->json('reference')->nullable();
            $this->timestampColumns($table);
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->nullOnDelete();
            $table->string('payment_no')->unique();
            $table->date('payment_date')->index();
            $table->decimal('amount_paid', 15, 2)->default(0);
            $table->string('payment_method')->index();
            $table->string('transaction_reference')->nullable()->index();
            $table->string('slip_path')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('completed')->index();
            $this->commonColumns($table);
        });

        Schema::create('payment_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('payments')->cascadeOnDelete();
            $table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();
            $table->decimal('allocated_amount', 15, 2)->default(0);
            $this->timestampColumns($table);
        });

        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('payments')->cascadeOnDelete();
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->nullOnDelete();
            $table->string('receipt_no')->unique();
            $table->decimal('amount_paid', 15, 2)->default(0);
            $table->decimal('balance_due', 15, 2)->default(0);
            $table->date('receipt_date')->index();
            $table->foreignId('received_by')->nullable()->constrained('system_users')->nullOnDelete();
            $table->string('pdf_path')->nullable();
            $table->string('status')->default('issued')->index();
            $this->commonColumns($table);
        });

        Schema::create('penalty_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartment_profile_id')->nullable()->constrained('apartment_profiles')->nullOnDelete();
            $table->string('rule_code')->unique();
            $table->string('name');
            $table->string('penalty_type')->default('percentage')->index();
            $table->decimal('rate_or_amount', 15, 4)->default(0);
            $table->unsignedInteger('grace_days')->default(0);
            $table->decimal('maximum_penalty', 15, 2)->nullable();
            $table->string('status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('debt_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->nullOnDelete();
            $table->string('reminder_no')->unique();
            $table->string('reminder_channel')->index();
            $table->date('reminder_date')->index();
            $table->decimal('amount_due', 15, 2)->default(0);
            $table->unsignedInteger('overdue_days')->default(0);
            $table->text('message')->nullable();
            $table->string('delivery_status')->default('pending')->index();
            $this->commonColumns($table);
        });

        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->foreignId('assigned_staff_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->string('request_no')->unique();
            $table->string('problem_type')->index();
            $table->text('description')->nullable();
            $table->string('priority')->default('medium')->index();
            $table->json('photo_paths')->nullable();
            $table->decimal('material_cost', 15, 2)->default(0);
            $table->decimal('labor_cost', 15, 2)->default(0);
            $table->decimal('service_cost', 15, 2)->default(0);
            $table->decimal('other_cost', 15, 2)->default(0);
            $table->decimal('total_cost', 15, 2)->default(0);
            $table->timestamp('requested_at')->nullable()->index();
            $table->timestamp('completed_at')->nullable()->index();
            $table->string('status')->default('pending')->index();
            $this->commonColumns($table);
        });

        Schema::create('maintenance_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_request_id')->constrained('maintenance_requests')->cascadeOnDelete();
            $table->foreignId('updated_by_staff_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->string('status')->index();
            $table->text('notes')->nullable();
            $table->json('photo_paths')->nullable();
            $this->timestampColumns($table);
        });

        Schema::create('preventive_maintenance_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->nullable()->constrained('buildings')->nullOnDelete();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->foreignId('assigned_staff_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->string('schedule_no')->unique();
            $table->string('maintenance_type')->index();
            $table->date('scheduled_date')->index();
            $table->date('completed_date')->nullable();
            $table->text('checklist')->nullable();
            $table->text('result_notes')->nullable();
            $table->string('status')->default('scheduled')->index();
            $this->commonColumns($table);
        });

        Schema::create('cleaning_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->foreignId('building_id')->nullable()->constrained('buildings')->nullOnDelete();
            $table->foreignId('assigned_staff_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->string('task_no')->unique();
            $table->string('area_type')->default('room')->index();
            $table->string('public_area')->nullable();
            $table->date('cleaning_date')->index();
            $table->text('remark')->nullable();
            $table->json('photo_paths')->nullable();
            $table->string('status')->default('pending')->index();
            $this->commonColumns($table);
        });

        Schema::create('cleaning_checklist_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cleaning_task_id')->constrained('cleaning_tasks')->cascadeOnDelete();
            $table->string('item_name');
            $table->boolean('is_completed')->default(false);
            $table->text('notes')->nullable();
            $this->timestampColumns($table);
        });

        Schema::create('inventory_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_code')->unique();
            $table->string('supplier_name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('payment_term')->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->string('status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_category_id')->nullable()->constrained('inventory_categories')->nullOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->string('item_code')->unique();
            $table->string('item_name');
            $table->string('unit')->nullable();
            $table->decimal('purchase_price', 15, 2)->default(0);
            $table->decimal('current_stock', 15, 3)->default(0);
            $table->decimal('minimum_stock', 15, 3)->default(0);
            $table->string('status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers')->cascadeOnDelete();
            $table->string('po_no')->unique();
            $table->date('po_date')->index();
            $table->date('expected_delivery_date')->nullable()->index();
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->foreignId('approved_by')->nullable()->constrained('system_users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->string('status')->default('draft')->index();
            $this->commonColumns($table);
        });

        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->cascadeOnDelete();
            $table->foreignId('inventory_item_id')->constrained('inventory_items')->cascadeOnDelete();
            $table->decimal('quantity', 15, 3)->default(0);
            $table->decimal('price', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $this->timestampColumns($table);
        });

        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->nullable()->constrained('purchase_orders')->nullOnDelete();
            $table->string('grn_no')->unique();
            $table->date('received_date')->index();
            $table->foreignId('received_by')->nullable()->constrained('system_users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->string('status')->default('received')->index();
            $this->commonColumns($table);
        });

        Schema::create('goods_receipt_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goods_receipt_id')->constrained('goods_receipts')->cascadeOnDelete();
            $table->foreignId('inventory_item_id')->constrained('inventory_items')->cascadeOnDelete();
            $table->decimal('received_quantity', 15, 3)->default(0);
            $table->decimal('damaged_quantity', 15, 3)->default(0);
            $table->decimal('unit_price', 15, 2)->default(0);
            $this->timestampColumns($table);
        });

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_item_id')->constrained('inventory_items')->cascadeOnDelete();
            $table->string('movement_no')->unique();
            $table->string('movement_type')->index();
            $table->decimal('quantity', 15, 3)->default(0);
            $table->decimal('unit_cost', 15, 2)->default(0);
            $table->decimal('total_cost', 15, 2)->default(0);
            $table->string('reference_type')->nullable()->index();
            $table->unsignedBigInteger('reference_id')->nullable()->index();
            $table->date('movement_date')->index();
            $table->foreignId('performed_by')->nullable()->constrained('system_users')->nullOnDelete();
            $table->text('notes')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->foreignId('inventory_item_id')->nullable()->constrained('inventory_items')->nullOnDelete();
            $table->string('asset_code')->unique();
            $table->string('asset_name');
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_price', 15, 2)->default(0);
            $table->string('condition')->nullable()->index();
            $table->date('warranty_expiry_date')->nullable()->index();
            $table->decimal('depreciation_rate', 8, 4)->nullable();
            $table->string('status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('room_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();
            $table->date('assigned_date')->nullable();
            $table->date('removed_date')->nullable();
            $table->string('condition_on_assign')->nullable();
            $table->string('condition_on_remove')->nullable();
            $table->unique(['room_id', 'asset_id']);
            $this->timestampColumns($table);
        });

        Schema::create('staff_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete();
            $table->string('document_code')->unique();
            $table->string('document_type')->index();
            $table->string('title');
            $table->string('file_path');
            $table->date('expiry_date')->nullable()->index();
            $this->commonColumns($table);
        });

        Schema::create('staff_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete();
            $table->date('attendance_date')->index();
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->integer('late_minutes')->default(0);
            $table->integer('early_leave_minutes')->default(0);
            $table->string('attendance_status')->default('present')->index();
            $table->text('notes')->nullable();
            $table->unique(['staff_id', 'attendance_date']);
            $this->commonColumns($table);
        });

        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete();
            $table->string('payroll_no')->unique();
            $table->string('payroll_month', 7)->index();
            $table->decimal('basic_salary', 15, 2)->default(0);
            $table->decimal('overtime_amount', 15, 2)->default(0);
            $table->decimal('allowance_amount', 15, 2)->default(0);
            $table->decimal('deduction_amount', 15, 2)->default(0);
            $table->decimal('bonus_amount', 15, 2)->default(0);
            $table->decimal('net_salary', 15, 2)->default(0);
            $table->date('paid_date')->nullable()->index();
            $table->string('payslip_path')->nullable();
            $table->string('status')->default('draft')->index();
            $this->commonColumns($table);
        });

        Schema::create('payroll_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_id')->constrained('payrolls')->cascadeOnDelete();
            $table->string('item_type')->index();
            $table->string('description');
            $table->decimal('amount', 15, 2)->default(0);
            $this->timestampColumns($table);
        });

        Schema::create('accounting_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_code')->unique();
            $table->string('name');
            $table->string('category_type')->index();
            $table->text('description')->nullable();
            $table->string('status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('accounting_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accounting_category_id')->nullable()->constrained('accounting_categories')->nullOnDelete();
            $table->string('transaction_no')->unique();
            $table->string('transaction_type')->index();
            $table->date('transaction_date')->index();
            $table->string('description');
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('payment_method')->nullable()->index();
            $table->string('reference_type')->nullable()->index();
            $table->unsignedBigInteger('reference_id')->nullable()->index();
            $table->string('attachment_path')->nullable();
            $table->string('status')->default('posted')->index();
            $this->commonColumns($table);
        });

        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartment_profile_id')->nullable()->constrained('apartment_profiles')->nullOnDelete();
            $table->string('gateway_code')->unique();
            $table->string('gateway_name');
            $table->string('provider')->index();
            $table->json('configuration')->nullable();
            $table->boolean('sandbox_mode')->default(true);
            $table->string('status')->default('inactive')->index();
            $this->commonColumns($table);
        });

        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->foreignId('converted_tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->string('lead_no')->unique();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('source')->nullable()->index();
            $table->date('appointment_date')->nullable()->index();
            $table->text('interest_notes')->nullable();
            $table->string('status')->default('new')->index();
            $this->commonColumns($table);
        });

        Schema::create('lead_followups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->foreignId('staff_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->dateTime('followup_at')->index();
            $table->string('followup_type')->nullable()->index();
            $table->text('notes')->nullable();
            $table->string('next_action')->nullable();
            $table->dateTime('next_followup_at')->nullable()->index();
            $this->timestampColumns($table);
        });

        Schema::create('controlled_documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_code')->unique();
            $table->string('document_type')->index();
            $table->string('title');
            $table->string('version_number')->default('1.0');
            $table->date('effective_date')->nullable()->index();
            $table->foreignId('prepared_by')->nullable()->constrained('system_users')->nullOnDelete();
            $table->foreignId('reviewed_by')->nullable()->constrained('system_users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('system_users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->string('file_path')->nullable();
            $table->string('status')->default('draft')->index();
            $this->commonColumns($table);
        });

        Schema::create('controlled_document_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('controlled_document_id')->constrained('controlled_documents')->cascadeOnDelete();
            $table->string('version_number');
            $table->text('revision_summary')->nullable();
            $table->foreignId('revised_by')->nullable()->constrained('system_users')->nullOnDelete();
            $table->timestamp('revised_at')->nullable();
            $table->string('file_path')->nullable();
            $this->timestampColumns($table);
        });

        Schema::create('record_controls', function (Blueprint $table) {
            $table->id();
            $table->string('record_code')->unique();
            $table->string('record_type')->index();
            $table->string('storage_location')->nullable();
            $table->string('retention_period')->nullable();
            $table->foreignId('responsible_person_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->string('disposal_method')->nullable();
            $table->date('disposal_due_date')->nullable()->index();
            $table->string('status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->foreignId('responsible_staff_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->string('complaint_no')->unique();
            $table->string('complaint_type')->index();
            $table->text('description')->nullable();
            $table->json('photo_paths')->nullable();
            $table->date('received_date')->nullable()->index();
            $table->date('resolved_date')->nullable()->index();
            $table->string('status')->default('open')->index();
            $this->commonColumns($table);
        });

        Schema::create('capa_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->nullable()->constrained('complaints')->nullOnDelete();
            $table->foreignId('responsible_staff_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->string('capa_no')->unique();
            $table->text('root_cause')->nullable();
            $table->text('corrective_action')->nullable();
            $table->text('preventive_action')->nullable();
            $table->date('due_date')->nullable()->index();
            $table->text('verification_of_effectiveness')->nullable();
            $table->date('verified_date')->nullable()->index();
            $table->string('status')->default('open')->index();
            $this->commonColumns($table);
        });

        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->unsignedTinyInteger('rating')->nullable();
            $table->text('comment')->nullable();
            $table->unsignedTinyInteger('service_quality_score')->nullable();
            $table->unsignedTinyInteger('cleanliness_score')->nullable();
            $table->unsignedTinyInteger('security_score')->nullable();
            $table->unsignedTinyInteger('overall_satisfaction_score')->nullable();
            $table->date('feedback_date')->nullable()->index();
            $table->string('status')->default('new')->index();
            $this->commonColumns($table);
        });

        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->string('template_code')->unique();
            $table->string('template_type')->index();
            $table->string('channel')->index();
            $table->string('subject')->nullable();
            $table->longText('body');
            $table->json('variables')->nullable();
            $table->string('status')->default('active')->index();
            $this->commonColumns($table);
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->nullable()->constrained('notification_templates')->nullOnDelete();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('system_users')->nullOnDelete();
            $table->string('notification_no')->unique();
            $table->string('channel')->index();
            $table->string('notification_type')->index();
            $table->string('recipient')->nullable()->index();
            $table->string('subject')->nullable();
            $table->longText('message');
            $table->string('reference_type')->nullable()->index();
            $table->unsignedBigInteger('reference_id')->nullable()->index();
            $table->timestamp('scheduled_at')->nullable()->index();
            $table->timestamp('sent_at')->nullable()->index();
            $table->timestamp('read_at')->nullable()->index();
            $table->string('status')->default('pending')->index();
            $this->commonColumns($table);
        });

        Schema::create('report_exports', function (Blueprint $table) {
            $table->id();
            $table->string('export_no')->unique();
            $table->string('report_type')->index();
            $table->json('filters')->nullable();
            $table->string('format')->index();
            $table->string('file_path')->nullable();
            $table->foreignId('requested_by')->nullable()->constrained('system_users')->nullOnDelete();
            $table->timestamp('requested_at')->nullable()->index();
            $table->timestamp('completed_at')->nullable()->index();
            $table->string('status')->default('pending')->index();
            $this->commonColumns($table);
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('system_users')->nullOnDelete();
            $table->string('module')->index();
            $table->string('action')->index();
            $table->string('auditable_type')->nullable()->index();
            $table->unsignedBigInteger('auditable_id')->nullable()->index();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address')->nullable()->index();
            $table->string('user_agent')->nullable();
            $table->timestamp('performed_at')->nullable()->index();
            $this->timestampColumns($table);
        });

        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartment_profile_id')->nullable()->constrained('apartment_profiles')->nullOnDelete();
            $table->string('setting_group')->index();
            $table->string('setting_key')->index();
            $table->longText('setting_value')->nullable();
            $table->string('value_type')->default('string');
            $table->boolean('is_encrypted')->default(false);
            $table->text('description')->nullable();
            $table->unique(['apartment_profile_id', 'setting_group', 'setting_key'], 'system_settings_unique_key');
            $this->commonColumns($table);
        });

        Schema::create('backup_logs', function (Blueprint $table) {
            $table->id();
            $table->string('backup_no')->unique();
            $table->string('backup_type')->default('database')->index();
            $table->string('storage_location')->nullable();
            $table->string('file_path')->nullable();
            $table->unsignedBigInteger('file_size_bytes')->nullable();
            $table->timestamp('started_at')->nullable()->index();
            $table->timestamp('completed_at')->nullable()->index();
            $table->timestamp('restore_tested_at')->nullable();
            $table->string('status')->default('pending')->index();
            $table->text('error_message')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('media_files', function (Blueprint $table) {
            $table->id();
            $table->string('fileable_type')->nullable()->index();
            $table->unsignedBigInteger('fileable_id')->nullable()->index();
            $table->string('collection')->nullable()->index();
            $table->string('original_name');
            $table->string('file_name');
            $table->string('mime_type')->nullable();
            $table->string('disk')->default('public');
            $table->string('path');
            $table->unsignedBigInteger('size_bytes')->nullable();
            $table->json('custom_properties')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('system_users')->nullOnDelete();
            $this->commonColumns($table);
        });
    }

    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $tables = [
            'media_files',
            'backup_logs',
            'system_settings',
            'audit_logs',
            'report_exports',
            'notifications',
            'notification_templates',
            'feedback',
            'capa_actions',
            'complaints',
            'record_controls',
            'controlled_document_revisions',
            'controlled_documents',
            'lead_followups',
            'leads',
            'payment_gateways',
            'accounting_transactions',
            'accounting_categories',
            'payroll_items',
            'payrolls',
            'staff_attendances',
            'staff_documents',
            'room_assets',
            'assets',
            'stock_movements',
            'goods_receipt_items',
            'goods_receipts',
            'purchase_order_items',
            'purchase_orders',
            'inventory_items',
            'suppliers',
            'inventory_categories',
            'cleaning_checklist_items',
            'cleaning_tasks',
            'preventive_maintenance_schedules',
            'maintenance_updates',
            'maintenance_requests',
            'debt_reminders',
            'penalty_rules',
            'receipts',
            'payment_allocations',
            'payments',
            'invoice_items',
            'invoices',
            'room_service_fees',
            'service_fees',
            'utility_readings',
            'utility_meters',
            'utility_rates',
            'utility_types',
            'move_out_records',
            'move_in_records',
            'contract_terminations',
            'contract_renewals',
            'rental_contracts',
            'reservations',
            'tenant_documents',
            'room_facility',
            'rooms',
            'room_type_facility',
            'facilities',
            'room_types',
            'floors',
            'buildings',
            'user_permission',
            'user_role',
            'role_permission',
            'system_users',
            'system_permissions',
            'system_roles',
            'tenant_contacts',
            'tenants',
            'staff',
            'departments',
            'legal_documents',
            'apartment_profiles',
            'property_owners',
        ];

        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    private function commonColumns(Blueprint $table): void
    {
        $table->unsignedBigInteger('created_by')->nullable()->index();
        $table->unsignedBigInteger('updated_by')->nullable()->index();
        $table->unsignedBigInteger('deleted_by')->nullable()->index();
        $table->json('metadata')->nullable();
        $table->timestamps();
        $table->softDeletes();
    }

    private function timestampColumns(Blueprint $table): void
    {
        $table->timestamps();
    }
};
