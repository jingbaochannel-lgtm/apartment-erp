<?php

/**
 * Source-of-truth for `scripts/generate_models.php`. Each entry maps
 * a database table name to the metadata needed to render its Eloquent
 * model class — fillable columns, casts, relations, traits, etc.
 *
 * Hand-edit when the migration changes; do NOT edit the generated
 * Model files directly because they will be overwritten the next time
 * the generator runs.
 */

declare(strict_types=1);

/* ----------------------------------------------------------------------
 | Common column collections used by most tables.
 *--------------------------------------------------------------------- */
$auditCols = ['created_by', 'updated_by', 'deleted_by', 'metadata'];
$jsonMetaCast = ['metadata' => 'array'];

return [
    /* =====================================================================
     | Property / branch (apartment_profile = "branch")
     *==================================================================== */
    'property_owners' => [
        'class' => 'PropertyOwner',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'owner_code', 'name', 'phone', 'email', 'address',
            'ownership_percentage', 'bank_name', 'bank_account_name',
            'bank_account_number', 'status',
        ], $auditCols),
        'casts' => array_merge(['ownership_percentage' => 'decimal:2'], $jsonMetaCast),
    ],

    'apartment_profiles' => [
        'class' => 'ApartmentProfile',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'property_owner_id', 'apartment_code', 'name', 'logo_path',
            'address', 'phone', 'email', 'website',
            'tax_identification_number', 'business_license_number',
            'stamp_path', 'signature_path', 'currency', 'timezone', 'status',
        ], $auditCols),
        'casts' => $jsonMetaCast,
        'belongs_to' => [
            'propertyOwner' => ['PropertyOwner', 'property_owner_id'],
        ],
        'has_many' => [
            'buildings' => ['Building', 'apartment_profile_id'],
            'departments' => ['Department', 'apartment_profile_id'],
            'tenants' => ['Tenant', 'apartment_profile_id'],
        ],
    ],

    'legal_documents' => [
        'class' => 'LegalDocument',
        'soft_deletes' => true,
        'audit' => true,
        'apartment_aware' => true,
        'fillable' => array_merge([
            'apartment_profile_id', 'document_code', 'document_type', 'title',
            'license_or_reference_no', 'issue_date', 'expiry_date',
            'file_path', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'issue_date' => 'date',
            'expiry_date' => 'date',
        ], $jsonMetaCast),
    ],

    /* =====================================================================
     | Organisation
     *==================================================================== */
    'departments' => [
        'class' => 'Department',
        'soft_deletes' => true,
        'audit' => true,
        'apartment_aware' => true,
        'fillable' => array_merge([
            'apartment_profile_id', 'department_code', 'name', 'description', 'status',
        ], $auditCols),
        'casts' => $jsonMetaCast,
        'has_many' => [
            'staff' => ['Staff', 'department_id'],
        ],
    ],

    'staff' => [
        'class' => 'Staff',
        'soft_deletes' => true,
        'audit' => true,
        'apartment_aware' => true,
        'fillable' => array_merge([
            'apartment_profile_id', 'department_id', 'staff_code', 'full_name',
            'position', 'phone', 'email', 'address', 'hire_date',
            'basic_salary', 'employment_status',
        ], $auditCols),
        'casts' => array_merge([
            'hire_date' => 'date',
            'basic_salary' => 'decimal:2',
        ], $jsonMetaCast),
        'belongs_to' => [
            'department' => ['Department', 'department_id'],
        ],
        'has_many' => [
            'documents' => ['StaffDocument', 'staff_id'],
            'attendances' => ['StaffAttendance', 'staff_id'],
            'payrolls' => ['Payroll', 'staff_id'],
        ],
    ],

    /* =====================================================================
     | Tenants
     *==================================================================== */
    'tenants' => [
        'class' => 'Tenant',
        'soft_deletes' => true,
        'audit' => true,
        'apartment_aware' => true,
        'fillable' => array_merge([
            'apartment_profile_id', 'tenant_code', 'full_name', 'gender',
            'date_of_birth', 'phone', 'email', 'address', 'occupation',
            'nationality', 'id_card_number', 'passport_number',
            'photo_path', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'date_of_birth' => 'date',
        ], $jsonMetaCast),
        'has_many' => [
            'contacts' => ['TenantContact', 'tenant_id'],
            'documents' => ['TenantDocument', 'tenant_id'],
            'contracts' => ['RentalContract', 'tenant_id'],
            'invoices' => ['Invoice', 'tenant_id'],
            'payments' => ['Payment', 'tenant_id'],
        ],
    ],

    'tenant_contacts' => [
        'class' => 'TenantContact',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'tenant_id', 'contact_type', 'name', 'relationship',
            'phone', 'email', 'address',
        ], $auditCols),
        'casts' => $jsonMetaCast,
        'belongs_to' => [
            'tenant' => ['Tenant', 'tenant_id'],
        ],
    ],

    'tenant_documents' => [
        'class' => 'TenantDocument',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'tenant_id', 'document_code', 'document_type', 'title', 'file_path',
            'issue_date', 'expiry_date', 'is_verified', 'verified_by', 'verified_at',
        ], $auditCols),
        'casts' => array_merge([
            'issue_date' => 'date',
            'expiry_date' => 'date',
            'is_verified' => 'boolean',
            'verified_at' => 'datetime',
        ], $jsonMetaCast),
        'belongs_to' => [
            'tenant' => ['Tenant', 'tenant_id'],
        ],
    ],

    /* =====================================================================
     | RBAC + System users
     *==================================================================== */
    'system_roles' => [
        'class' => 'SystemRole',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'role_code', 'name', 'description', 'is_system', 'status',
        ], $auditCols),
        'casts' => array_merge(['is_system' => 'boolean'], $jsonMetaCast),
        'belongs_to_many' => [
            'permissions' => ['SystemPermission', 'role_permission', 'role_id', 'permission_id'],
            'users' => ['SystemUser', 'user_role', 'role_id', 'user_id'],
        ],
    ],

    'system_permissions' => [
        'class' => 'SystemPermission',
        'fillable' => [
            'permission_code', 'module', 'action', 'name', 'description',
        ],
        'belongs_to_many' => [
            'roles' => ['SystemRole', 'role_permission', 'permission_id', 'role_id'],
            'users' => ['SystemUser', 'user_permission', 'permission_id', 'user_id'],
        ],
    ],

    'system_users' => [
        'class' => 'SystemUser',
        'is_user' => true,
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'staff_id', 'tenant_id', 'name', 'username', 'email', 'phone',
            'password', 'user_type', 'two_factor_enabled', 'two_factor_secret',
            'last_login_at', 'last_login_ip', 'failed_login_attempts',
            'locked_until', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'two_factor_enabled' => 'boolean',
            'last_login_at' => 'datetime',
            'locked_until' => 'datetime',
            'password' => 'hashed',
        ], $jsonMetaCast),
        'hidden' => ['password', 'remember_token', 'two_factor_secret'],
        'belongs_to' => [
            'staff' => ['Staff', 'staff_id'],
            'tenant' => ['Tenant', 'tenant_id'],
        ],
        'belongs_to_many' => [
            'roles' => ['SystemRole', 'user_role', 'user_id', 'role_id'],
            'directPermissions' => ['SystemPermission', 'user_permission', 'user_id', 'permission_id'],
        ],
    ],

    'role_permission' => [
        'class' => 'RolePermission',
        'fillable' => ['role_id', 'permission_id'],
    ],

    'user_role' => [
        'class' => 'UserRole',
        'fillable' => ['user_id', 'role_id'],
    ],

    'user_permission' => [
        'class' => 'UserPermission',
        'fillable' => ['user_id', 'permission_id', 'allowed'],
        'casts' => ['allowed' => 'boolean'],
    ],

    /* =====================================================================
     | Property hierarchy
     *==================================================================== */
    'buildings' => [
        'class' => 'Building',
        'soft_deletes' => true,
        'audit' => true,
        'apartment_aware' => true,
        'fillable' => array_merge([
            'apartment_profile_id', 'manager_staff_id', 'building_code', 'name',
            'location', 'total_floors', 'total_rooms', 'status',
        ], $auditCols),
        'casts' => $jsonMetaCast,
        'belongs_to' => [
            'manager' => ['Staff', 'manager_staff_id'],
        ],
        'has_many' => [
            'floors' => ['Floor', 'building_id'],
            'rooms' => ['Room', 'building_id'],
        ],
    ],

    'floors' => [
        'class' => 'Floor',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'building_id', 'floor_code', 'floor_number', 'room_count',
            'floor_map_path', 'status', 'notes',
        ], $auditCols),
        'casts' => $jsonMetaCast,
        'belongs_to' => [
            'building' => ['Building', 'building_id'],
        ],
        'has_many' => [
            'rooms' => ['Room', 'floor_id'],
        ],
    ],

    'room_types' => [
        'class' => 'RoomType',
        'soft_deletes' => true,
        'audit' => true,
        'apartment_aware' => true,
        'fillable' => array_merge([
            'apartment_profile_id', 'type_code', 'name', 'description',
            'default_monthly_rent', 'default_deposit_amount',
            'default_capacity', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'default_monthly_rent' => 'decimal:2',
            'default_deposit_amount' => 'decimal:2',
        ], $jsonMetaCast),
        'belongs_to_many' => [
            'facilities' => ['Facility', 'room_type_facility', 'room_type_id', 'facility_id'],
        ],
    ],

    'facilities' => [
        'class' => 'Facility',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'facility_code', 'name', 'category', 'description', 'status',
        ], $auditCols),
        'casts' => $jsonMetaCast,
    ],

    'room_type_facility' => [
        'class' => 'RoomTypeFacility',
        'fillable' => ['room_type_id', 'facility_id', 'quantity'],
    ],

    'rooms' => [
        'class' => 'Room',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'building_id', 'floor_id', 'room_type_id', 'room_code', 'room_number',
            'size_sqm', 'capacity', 'monthly_rent', 'deposit_amount',
            'status', 'description', 'gallery_paths',
        ], $auditCols),
        'casts' => array_merge([
            'size_sqm' => 'decimal:2',
            'monthly_rent' => 'decimal:2',
            'deposit_amount' => 'decimal:2',
            'gallery_paths' => 'array',
        ], $jsonMetaCast),
        'belongs_to' => [
            'building' => ['Building', 'building_id'],
            'floor' => ['Floor', 'floor_id'],
            'roomType' => ['RoomType', 'room_type_id'],
        ],
        'has_many' => [
            'contracts' => ['RentalContract', 'room_id'],
            'assets' => ['RoomAsset', 'room_id'],
        ],
    ],

    'room_facility' => [
        'class' => 'RoomFacility',
        'fillable' => ['room_id', 'facility_id', 'quantity', 'condition', 'notes'],
    ],

    /* =====================================================================
     | Booking & Contracts
     *==================================================================== */
    'reservations' => [
        'class' => 'Reservation',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'room_id', 'tenant_id', 'reservation_no', 'customer_name',
            'phone', 'email', 'planned_move_in_date', 'deposit_amount',
            'deposit_paid_date', 'status', 'notes',
        ], $auditCols),
        'casts' => array_merge([
            'planned_move_in_date' => 'date',
            'deposit_paid_date' => 'date',
            'deposit_amount' => 'decimal:2',
        ], $jsonMetaCast),
        'belongs_to' => [
            'room' => ['Room', 'room_id'],
            'tenant' => ['Tenant', 'tenant_id'],
        ],
    ],

    'rental_contracts' => [
        'class' => 'RentalContract',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'tenant_id', 'room_id', 'reservation_id', 'contract_no',
            'start_date', 'end_date', 'monthly_rent', 'deposit_amount',
            'payment_due_day', 'terms_conditions', 'signed_contract_path',
            'signed_date', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'start_date' => 'date',
            'end_date' => 'date',
            'signed_date' => 'date',
            'monthly_rent' => 'decimal:2',
            'deposit_amount' => 'decimal:2',
        ], $jsonMetaCast),
        'belongs_to' => [
            'tenant' => ['Tenant', 'tenant_id'],
            'room' => ['Room', 'room_id'],
            'reservation' => ['Reservation', 'reservation_id'],
        ],
        'has_many' => [
            'renewals' => ['ContractRenewal', 'contract_id'],
            'terminations' => ['ContractTermination', 'contract_id'],
            'invoices' => ['Invoice', 'contract_id'],
        ],
    ],

    'contract_renewals' => [
        'class' => 'ContractRenewal',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'contract_id', 'renewal_no', 'old_end_date', 'new_start_date',
            'new_end_date', 'old_monthly_rent', 'new_monthly_rent',
            'old_deposit_amount', 'new_deposit_amount',
            'renewal_document_path', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'old_end_date' => 'date',
            'new_start_date' => 'date',
            'new_end_date' => 'date',
            'old_monthly_rent' => 'decimal:2',
            'new_monthly_rent' => 'decimal:2',
            'old_deposit_amount' => 'decimal:2',
            'new_deposit_amount' => 'decimal:2',
        ], $jsonMetaCast),
        'belongs_to' => [
            'contract' => ['RentalContract', 'contract_id'],
        ],
    ],

    'contract_terminations' => [
        'class' => 'ContractTermination',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'contract_id', 'termination_no', 'termination_date', 'reason',
            'outstanding_balance', 'deposit_deduction', 'deposit_refund',
            'termination_letter_path', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'termination_date' => 'date',
            'outstanding_balance' => 'decimal:2',
            'deposit_deduction' => 'decimal:2',
            'deposit_refund' => 'decimal:2',
        ], $jsonMetaCast),
        'belongs_to' => [
            'contract' => ['RentalContract', 'contract_id'],
        ],
    ],

    'move_in_records' => [
        'class' => 'MoveInRecord',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'contract_id', 'tenant_id', 'room_id', 'move_in_no', 'move_in_date',
            'room_condition', 'facility_condition', 'water_meter_reading',
            'electric_meter_reading', 'photo_paths', 'tenant_signature_path',
            'status',
        ], $auditCols),
        'casts' => array_merge([
            'move_in_date' => 'date',
            'water_meter_reading' => 'decimal:3',
            'electric_meter_reading' => 'decimal:3',
            'photo_paths' => 'array',
        ], $jsonMetaCast),
        'belongs_to' => [
            'contract' => ['RentalContract', 'contract_id'],
            'tenant' => ['Tenant', 'tenant_id'],
            'room' => ['Room', 'room_id'],
        ],
    ],

    'move_out_records' => [
        'class' => 'MoveOutRecord',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'contract_id', 'tenant_id', 'room_id', 'move_out_no', 'move_out_date',
            'room_condition', 'damaged_items', 'final_water_meter_reading',
            'final_electric_meter_reading', 'outstanding_balance',
            'damage_deduction', 'deposit_refund', 'photo_paths',
            'tenant_signature_path', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'move_out_date' => 'date',
            'final_water_meter_reading' => 'decimal:3',
            'final_electric_meter_reading' => 'decimal:3',
            'outstanding_balance' => 'decimal:2',
            'damage_deduction' => 'decimal:2',
            'deposit_refund' => 'decimal:2',
            'photo_paths' => 'array',
        ], $jsonMetaCast),
        'belongs_to' => [
            'contract' => ['RentalContract', 'contract_id'],
            'tenant' => ['Tenant', 'tenant_id'],
            'room' => ['Room', 'room_id'],
        ],
    ],

    /* =====================================================================
     | Utilities & Service fees
     *==================================================================== */
    'utility_types' => [
        'class' => 'UtilityType',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'utility_code', 'name', 'unit', 'billing_method', 'status',
        ], $auditCols),
        'casts' => $jsonMetaCast,
    ],

    'utility_rates' => [
        'class' => 'UtilityRate',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'utility_type_id', 'price_per_unit', 'minimum_charge',
            'effective_from', 'effective_to', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'price_per_unit' => 'decimal:4',
            'minimum_charge' => 'decimal:2',
            'effective_from' => 'date',
            'effective_to' => 'date',
        ], $jsonMetaCast),
        'belongs_to' => [
            'utilityType' => ['UtilityType', 'utility_type_id'],
        ],
    ],

    'utility_meters' => [
        'class' => 'UtilityMeter',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'room_id', 'utility_type_id', 'meter_no', 'initial_reading',
            'installed_date', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'initial_reading' => 'decimal:3',
            'installed_date' => 'date',
        ], $jsonMetaCast),
        'belongs_to' => [
            'room' => ['Room', 'room_id'],
            'utilityType' => ['UtilityType', 'utility_type_id'],
        ],
    ],

    'utility_readings' => [
        'class' => 'UtilityReading',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'utility_meter_id', 'room_id', 'contract_id', 'reading_no',
            'reading_date', 'billing_month', 'old_reading', 'new_reading',
            'usage_unit', 'price_per_unit', 'total_fee', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'reading_date' => 'date',
            'old_reading' => 'decimal:3',
            'new_reading' => 'decimal:3',
            'usage_unit' => 'decimal:3',
            'price_per_unit' => 'decimal:4',
            'total_fee' => 'decimal:2',
        ], $jsonMetaCast),
        'belongs_to' => [
            'meter' => ['UtilityMeter', 'utility_meter_id'],
            'room' => ['Room', 'room_id'],
            'contract' => ['RentalContract', 'contract_id'],
        ],
    ],

    'service_fees' => [
        'class' => 'ServiceFee',
        'soft_deletes' => true,
        'audit' => true,
        'apartment_aware' => true,
        'fillable' => array_merge([
            'apartment_profile_id', 'service_code', 'name', 'fee_type',
            'amount', 'status',
        ], $auditCols),
        'casts' => array_merge(['amount' => 'decimal:2'], $jsonMetaCast),
    ],

    'room_service_fees' => [
        'class' => 'RoomServiceFee',
        'fillable' => ['room_id', 'service_fee_id', 'amount', 'effective_from', 'effective_to'],
        'casts' => [
            'amount' => 'decimal:2',
            'effective_from' => 'date',
            'effective_to' => 'date',
        ],
    ],

    /* =====================================================================
     | Billing
     *==================================================================== */
    'invoices' => [
        'class' => 'Invoice',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'tenant_id', 'room_id', 'contract_id', 'invoice_no', 'billing_month',
            'invoice_date', 'due_date', 'room_fee', 'water_fee', 'electricity_fee',
            'service_fee', 'old_balance', 'discount', 'penalty', 'subtotal',
            'grand_total', 'paid_amount', 'balance_due', 'pdf_path', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'invoice_date' => 'date',
            'due_date' => 'date',
            'room_fee' => 'decimal:2',
            'water_fee' => 'decimal:2',
            'electricity_fee' => 'decimal:2',
            'service_fee' => 'decimal:2',
            'old_balance' => 'decimal:2',
            'discount' => 'decimal:2',
            'penalty' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'grand_total' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'balance_due' => 'decimal:2',
        ], $jsonMetaCast),
        'belongs_to' => [
            'tenant' => ['Tenant', 'tenant_id'],
            'room' => ['Room', 'room_id'],
            'contract' => ['RentalContract', 'contract_id'],
        ],
        'has_many' => [
            'items' => ['InvoiceItem', 'invoice_id'],
            'allocations' => ['PaymentAllocation', 'invoice_id'],
        ],
    ],

    'invoice_items' => [
        'class' => 'InvoiceItem',
        'fillable' => [
            'invoice_id', 'item_type', 'description', 'quantity',
            'unit_price', 'amount', 'reference',
        ],
        'casts' => [
            'quantity' => 'decimal:3',
            'unit_price' => 'decimal:4',
            'amount' => 'decimal:2',
            'reference' => 'array',
        ],
        'belongs_to' => [
            'invoice' => ['Invoice', 'invoice_id'],
        ],
    ],

    'payments' => [
        'class' => 'Payment',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'tenant_id', 'invoice_id', 'payment_no', 'payment_date',
            'amount_paid', 'payment_method', 'transaction_reference',
            'slip_path', 'notes', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'payment_date' => 'date',
            'amount_paid' => 'decimal:2',
        ], $jsonMetaCast),
        'belongs_to' => [
            'tenant' => ['Tenant', 'tenant_id'],
            'invoice' => ['Invoice', 'invoice_id'],
        ],
        'has_many' => [
            'allocations' => ['PaymentAllocation', 'payment_id'],
            'receipts' => ['Receipt', 'payment_id'],
        ],
    ],

    'payment_allocations' => [
        'class' => 'PaymentAllocation',
        'fillable' => ['payment_id', 'invoice_id', 'allocated_amount'],
        'casts' => ['allocated_amount' => 'decimal:2'],
    ],

    'receipts' => [
        'class' => 'Receipt',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'payment_id', 'invoice_id', 'receipt_no', 'amount_paid',
            'balance_due', 'receipt_date', 'received_by', 'pdf_path', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'amount_paid' => 'decimal:2',
            'balance_due' => 'decimal:2',
            'receipt_date' => 'date',
        ], $jsonMetaCast),
        'belongs_to' => [
            'payment' => ['Payment', 'payment_id'],
            'invoice' => ['Invoice', 'invoice_id'],
        ],
    ],

    'penalty_rules' => [
        'class' => 'PenaltyRule',
        'soft_deletes' => true,
        'audit' => true,
        'apartment_aware' => true,
        'fillable' => array_merge([
            'apartment_profile_id', 'rule_code', 'name', 'penalty_type',
            'rate_or_amount', 'grace_days', 'maximum_penalty', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'rate_or_amount' => 'decimal:4',
            'maximum_penalty' => 'decimal:2',
        ], $jsonMetaCast),
    ],

    'debt_reminders' => [
        'class' => 'DebtReminder',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'tenant_id', 'invoice_id', 'reminder_no', 'reminder_channel',
            'reminder_date', 'amount_due', 'overdue_days', 'message',
            'delivery_status',
        ], $auditCols),
        'casts' => array_merge([
            'reminder_date' => 'date',
            'amount_due' => 'decimal:2',
        ], $jsonMetaCast),
        'belongs_to' => [
            'tenant' => ['Tenant', 'tenant_id'],
            'invoice' => ['Invoice', 'invoice_id'],
        ],
    ],

    /* =====================================================================
     | Maintenance + Cleaning
     *==================================================================== */
    'maintenance_requests' => [
        'class' => 'MaintenanceRequest',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'room_id', 'tenant_id', 'assigned_staff_id', 'request_no',
            'problem_type', 'description', 'priority', 'photo_paths',
            'material_cost', 'labor_cost', 'service_cost', 'other_cost',
            'total_cost', 'requested_at', 'completed_at', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'photo_paths' => 'array',
            'material_cost' => 'decimal:2',
            'labor_cost' => 'decimal:2',
            'service_cost' => 'decimal:2',
            'other_cost' => 'decimal:2',
            'total_cost' => 'decimal:2',
            'requested_at' => 'datetime',
            'completed_at' => 'datetime',
        ], $jsonMetaCast),
        'belongs_to' => [
            'room' => ['Room', 'room_id'],
            'tenant' => ['Tenant', 'tenant_id'],
            'assignedStaff' => ['Staff', 'assigned_staff_id'],
        ],
        'has_many' => [
            'updates' => ['MaintenanceUpdate', 'maintenance_request_id'],
        ],
    ],

    'maintenance_updates' => [
        'class' => 'MaintenanceUpdate',
        'fillable' => [
            'maintenance_request_id', 'updated_by_staff_id', 'status',
            'notes', 'photo_paths',
        ],
        'casts' => ['photo_paths' => 'array'],
        'belongs_to' => [
            'request' => ['MaintenanceRequest', 'maintenance_request_id'],
            'staff' => ['Staff', 'updated_by_staff_id'],
        ],
    ],

    'preventive_maintenance_schedules' => [
        'class' => 'PreventiveMaintenanceSchedule',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'building_id', 'room_id', 'assigned_staff_id', 'schedule_no',
            'maintenance_type', 'scheduled_date', 'completed_date',
            'checklist', 'result_notes', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'scheduled_date' => 'date',
            'completed_date' => 'date',
        ], $jsonMetaCast),
    ],

    'cleaning_tasks' => [
        'class' => 'CleaningTask',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'room_id', 'building_id', 'assigned_staff_id', 'task_no',
            'area_type', 'public_area', 'cleaning_date', 'remark',
            'photo_paths', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'cleaning_date' => 'date',
            'photo_paths' => 'array',
        ], $jsonMetaCast),
        'has_many' => [
            'checklistItems' => ['CleaningChecklistItem', 'cleaning_task_id'],
        ],
    ],

    'cleaning_checklist_items' => [
        'class' => 'CleaningChecklistItem',
        'fillable' => ['cleaning_task_id', 'item_name', 'is_completed', 'notes'],
        'casts' => ['is_completed' => 'boolean'],
    ],

    /* =====================================================================
     | Inventory + Procurement
     *==================================================================== */
    'inventory_categories' => [
        'class' => 'InventoryCategory',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'category_code', 'name', 'description', 'status',
        ], $auditCols),
        'casts' => $jsonMetaCast,
    ],

    'suppliers' => [
        'class' => 'Supplier',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'supplier_code', 'supplier_name', 'phone', 'email', 'address',
            'contact_person', 'payment_term', 'rating', 'status',
        ], $auditCols),
        'casts' => array_merge(['rating' => 'decimal:2'], $jsonMetaCast),
    ],

    'inventory_items' => [
        'class' => 'InventoryItem',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'inventory_category_id', 'supplier_id', 'item_code', 'item_name',
            'unit', 'purchase_price', 'current_stock', 'minimum_stock', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'purchase_price' => 'decimal:2',
            'current_stock' => 'decimal:3',
            'minimum_stock' => 'decimal:3',
        ], $jsonMetaCast),
        'belongs_to' => [
            'category' => ['InventoryCategory', 'inventory_category_id'],
            'supplier' => ['Supplier', 'supplier_id'],
        ],
    ],

    'purchase_orders' => [
        'class' => 'PurchaseOrder',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'supplier_id', 'po_no', 'po_date', 'expected_delivery_date',
            'total_amount', 'approved_by', 'approved_at', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'po_date' => 'date',
            'expected_delivery_date' => 'date',
            'total_amount' => 'decimal:2',
            'approved_at' => 'datetime',
        ], $jsonMetaCast),
        'belongs_to' => [
            'supplier' => ['Supplier', 'supplier_id'],
        ],
        'has_many' => [
            'items' => ['PurchaseOrderItem', 'purchase_order_id'],
        ],
    ],

    'purchase_order_items' => [
        'class' => 'PurchaseOrderItem',
        'fillable' => ['purchase_order_id', 'inventory_item_id', 'quantity', 'price', 'total_amount'],
        'casts' => [
            'quantity' => 'decimal:3',
            'price' => 'decimal:2',
            'total_amount' => 'decimal:2',
        ],
    ],

    'goods_receipts' => [
        'class' => 'GoodsReceipt',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'purchase_order_id', 'grn_no', 'received_date', 'received_by',
            'notes', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'received_date' => 'date',
        ], $jsonMetaCast),
        'has_many' => [
            'items' => ['GoodsReceiptItem', 'goods_receipt_id'],
        ],
    ],

    'goods_receipt_items' => [
        'class' => 'GoodsReceiptItem',
        'fillable' => ['goods_receipt_id', 'inventory_item_id', 'received_quantity', 'damaged_quantity', 'unit_price'],
        'casts' => [
            'received_quantity' => 'decimal:3',
            'damaged_quantity' => 'decimal:3',
            'unit_price' => 'decimal:2',
        ],
    ],

    'stock_movements' => [
        'class' => 'StockMovement',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'inventory_item_id', 'movement_no', 'movement_type', 'quantity',
            'unit_cost', 'total_cost', 'reference_type', 'reference_id',
            'movement_date', 'performed_by', 'notes',
        ], $auditCols),
        'casts' => array_merge([
            'movement_date' => 'date',
            'quantity' => 'decimal:3',
            'unit_cost' => 'decimal:2',
            'total_cost' => 'decimal:2',
        ], $jsonMetaCast),
    ],

    'assets' => [
        'class' => 'Asset',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'room_id', 'inventory_item_id', 'asset_code', 'asset_name',
            'purchase_date', 'purchase_price', 'condition',
            'warranty_expiry_date', 'depreciation_rate', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'purchase_date' => 'date',
            'purchase_price' => 'decimal:2',
            'warranty_expiry_date' => 'date',
            'depreciation_rate' => 'decimal:4',
        ], $jsonMetaCast),
    ],

    'room_assets' => [
        'class' => 'RoomAsset',
        'fillable' => ['room_id', 'asset_id', 'assigned_date', 'removed_date', 'condition_on_assign', 'condition_on_remove'],
        'casts' => [
            'assigned_date' => 'date',
            'removed_date' => 'date',
        ],
    ],

    /* =====================================================================
     | HR
     *==================================================================== */
    'staff_documents' => [
        'class' => 'StaffDocument',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'staff_id', 'document_code', 'document_type', 'title',
            'file_path', 'expiry_date',
        ], $auditCols),
        'casts' => array_merge(['expiry_date' => 'date'], $jsonMetaCast),
    ],

    'staff_attendances' => [
        'class' => 'StaffAttendance',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'staff_id', 'attendance_date', 'time_in', 'time_out',
            'late_minutes', 'early_leave_minutes', 'attendance_status', 'notes',
        ], $auditCols),
        'casts' => array_merge([
            'attendance_date' => 'date',
        ], $jsonMetaCast),
    ],

    'payrolls' => [
        'class' => 'Payroll',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'staff_id', 'payroll_no', 'payroll_month', 'basic_salary',
            'overtime_amount', 'allowance_amount', 'deduction_amount',
            'bonus_amount', 'net_salary', 'paid_date', 'payslip_path', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'basic_salary' => 'decimal:2',
            'overtime_amount' => 'decimal:2',
            'allowance_amount' => 'decimal:2',
            'deduction_amount' => 'decimal:2',
            'bonus_amount' => 'decimal:2',
            'net_salary' => 'decimal:2',
            'paid_date' => 'date',
        ], $jsonMetaCast),
        'has_many' => [
            'items' => ['PayrollItem', 'payroll_id'],
        ],
    ],

    'payroll_items' => [
        'class' => 'PayrollItem',
        'fillable' => ['payroll_id', 'item_type', 'description', 'amount'],
        'casts' => ['amount' => 'decimal:2'],
    ],

    /* =====================================================================
     | Accounting + Payment Gateways
     *==================================================================== */
    'accounting_categories' => [
        'class' => 'AccountingCategory',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'category_code', 'name', 'category_type', 'description', 'status',
        ], $auditCols),
        'casts' => $jsonMetaCast,
    ],

    'accounting_transactions' => [
        'class' => 'AccountingTransaction',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'accounting_category_id', 'transaction_no', 'transaction_type',
            'transaction_date', 'description', 'amount', 'payment_method',
            'reference_type', 'reference_id', 'attachment_path', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'transaction_date' => 'date',
            'amount' => 'decimal:2',
        ], $jsonMetaCast),
        'belongs_to' => [
            'category' => ['AccountingCategory', 'accounting_category_id'],
        ],
    ],

    'payment_gateways' => [
        'class' => 'PaymentGateway',
        'soft_deletes' => true,
        'audit' => true,
        'apartment_aware' => true,
        'fillable' => array_merge([
            'apartment_profile_id', 'gateway_code', 'gateway_name', 'provider',
            'configuration', 'sandbox_mode', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'configuration' => 'array',
            'sandbox_mode' => 'boolean',
        ], $jsonMetaCast),
    ],

    /* =====================================================================
     | Sales / Marketing
     *==================================================================== */
    'leads' => [
        'class' => 'Lead',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'room_id', 'converted_tenant_id', 'lead_no', 'name', 'phone',
            'email', 'source', 'appointment_date', 'interest_notes', 'status',
        ], $auditCols),
        'casts' => array_merge(['appointment_date' => 'date'], $jsonMetaCast),
        'has_many' => [
            'followups' => ['LeadFollowup', 'lead_id'],
        ],
    ],

    'lead_followups' => [
        'class' => 'LeadFollowup',
        'fillable' => [
            'lead_id', 'staff_id', 'followup_at', 'followup_type',
            'notes', 'next_action', 'next_followup_at',
        ],
        'casts' => [
            'followup_at' => 'datetime',
            'next_followup_at' => 'datetime',
        ],
    ],

    /* =====================================================================
     | ISO 9001 — controlled documents, complaints, CAPA, feedback
     *==================================================================== */
    'controlled_documents' => [
        'class' => 'ControlledDocument',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'document_code', 'document_type', 'title', 'version_number',
            'effective_date', 'prepared_by', 'reviewed_by', 'approved_by',
            'approved_at', 'file_path', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'effective_date' => 'date',
            'approved_at' => 'datetime',
        ], $jsonMetaCast),
        'has_many' => [
            'revisions' => ['ControlledDocumentRevision', 'controlled_document_id'],
        ],
    ],

    'controlled_document_revisions' => [
        'class' => 'ControlledDocumentRevision',
        'fillable' => [
            'controlled_document_id', 'version_number', 'revision_summary',
            'revised_by', 'revised_at', 'file_path',
        ],
        'casts' => ['revised_at' => 'datetime'],
    ],

    'record_controls' => [
        'class' => 'RecordControl',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'record_code', 'record_type', 'storage_location', 'retention_period',
            'responsible_person_id', 'disposal_method', 'disposal_due_date', 'status',
        ], $auditCols),
        'casts' => array_merge(['disposal_due_date' => 'date'], $jsonMetaCast),
    ],

    'complaints' => [
        'class' => 'Complaint',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'tenant_id', 'room_id', 'responsible_staff_id', 'complaint_no',
            'complaint_type', 'description', 'photo_paths',
            'received_date', 'resolved_date', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'received_date' => 'date',
            'resolved_date' => 'date',
            'photo_paths' => 'array',
        ], $jsonMetaCast),
        'belongs_to' => [
            'tenant' => ['Tenant', 'tenant_id'],
            'room' => ['Room', 'room_id'],
            'staff' => ['Staff', 'responsible_staff_id'],
        ],
    ],

    'capa_actions' => [
        'class' => 'CapaAction',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'complaint_id', 'responsible_staff_id', 'capa_no', 'root_cause',
            'corrective_action', 'preventive_action', 'due_date',
            'verification_of_effectiveness', 'verified_date', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'due_date' => 'date',
            'verified_date' => 'date',
        ], $jsonMetaCast),
    ],

    'feedback' => [
        'class' => 'Feedback',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'tenant_id', 'room_id', 'rating', 'comment',
            'service_quality_score', 'cleanliness_score', 'security_score',
            'overall_satisfaction_score', 'feedback_date', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'feedback_date' => 'date',
        ], $jsonMetaCast),
    ],

    /* =====================================================================
     | Notifications + Reports
     *==================================================================== */
    'notification_templates' => [
        'class' => 'NotificationTemplate',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'template_code', 'template_type', 'channel', 'subject',
            'body', 'variables', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'variables' => 'array',
        ], $jsonMetaCast),
    ],

    'notifications' => [
        'class' => 'AppNotification',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'template_id', 'tenant_id', 'user_id', 'notification_no',
            'channel', 'notification_type', 'recipient', 'subject', 'message',
            'reference_type', 'reference_id', 'scheduled_at', 'sent_at',
            'read_at', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'scheduled_at' => 'datetime',
            'sent_at' => 'datetime',
            'read_at' => 'datetime',
        ], $jsonMetaCast),
    ],

    'report_exports' => [
        'class' => 'ReportExport',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'export_no', 'report_type', 'filters', 'format', 'file_path',
            'requested_by', 'requested_at', 'completed_at', 'status',
        ], $auditCols),
        'casts' => array_merge([
            'filters' => 'array',
            'requested_at' => 'datetime',
            'completed_at' => 'datetime',
        ], $jsonMetaCast),
    ],

    /* =====================================================================
     | System / infrastructure
     *==================================================================== */
    'audit_logs' => [
        'class' => 'AuditLog',
        'fillable' => [
            'user_id', 'module', 'action', 'auditable_type', 'auditable_id',
            'old_values', 'new_values', 'ip_address', 'user_agent', 'performed_at',
        ],
        'casts' => [
            'old_values' => 'array',
            'new_values' => 'array',
            'performed_at' => 'datetime',
        ],
    ],

    'system_settings' => [
        'class' => 'SystemSetting',
        'soft_deletes' => true,
        'audit' => true,
        'apartment_aware' => true,
        'fillable' => array_merge([
            'apartment_profile_id', 'setting_group', 'setting_key',
            'setting_value', 'value_type', 'is_encrypted', 'description',
        ], $auditCols),
        'casts' => array_merge([
            'is_encrypted' => 'boolean',
        ], $jsonMetaCast),
    ],

    'backup_logs' => [
        'class' => 'BackupLog',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'backup_no', 'backup_type', 'storage_location', 'file_path',
            'file_size_bytes', 'started_at', 'completed_at',
            'restore_tested_at', 'status', 'error_message',
        ], $auditCols),
        'casts' => array_merge([
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'restore_tested_at' => 'datetime',
        ], $jsonMetaCast),
    ],

    'media_files' => [
        'class' => 'MediaFile',
        'soft_deletes' => true,
        'audit' => true,
        'fillable' => array_merge([
            'fileable_type', 'fileable_id', 'collection', 'original_name',
            'file_name', 'mime_type', 'disk', 'path', 'size_bytes',
            'custom_properties', 'uploaded_by',
        ], $auditCols),
        'casts' => array_merge([
            'custom_properties' => 'array',
        ], $jsonMetaCast),
    ],
];
