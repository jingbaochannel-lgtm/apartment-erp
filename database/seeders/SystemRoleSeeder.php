<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Default RBAC seed. Creates a handful of canonical roles and grants the
 * super-admin role every permission. Other roles (manager / staff /
 * tenant_user) are created empty and can be tailored from the admin UI.
 */
class SystemRoleSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $roles = [
            [
                'role_code' => 'super_admin',
                'name' => 'Super Admin',
                'description' => 'Full system access',
                'is_system' => true,
            ],
            [
                'role_code' => 'branch_manager',
                'name' => 'Branch Manager',
                'description' => 'Manages a single apartment / branch',
                'is_system' => true,
            ],
            [
                'role_code' => 'accountant',
                'name' => 'Accountant',
                'description' => 'Manages invoices, payments, accounting transactions',
                'is_system' => true,
            ],
            [
                'role_code' => 'front_desk',
                'name' => 'Front Desk',
                'description' => 'Reservation / tenant / room operations',
                'is_system' => true,
            ],
            [
                'role_code' => 'maintenance_staff',
                'name' => 'Maintenance Staff',
                'description' => 'Maintenance + cleaning + assets',
                'is_system' => true,
            ],
            [
                'role_code' => 'tenant_user',
                'name' => 'Tenant',
                'description' => 'Self-service tenant portal account',
                'is_system' => true,
            ],
        ];

        $rows = collect($roles)->map(fn ($r) => array_merge($r, [
            'status' => 'active',
            'created_at' => $now,
            'updated_at' => $now,
        ]))->all();

        DB::table('system_roles')->upsert(
            $rows,
            ['role_code'],
            ['name', 'description', 'is_system', 'status', 'updated_at']
        );

        $this->grantAllToSuperAdmin();
    }

    /**
     * Wire every existing permission to the super_admin role. Idempotent
     * via `upsert` on the composite role/permission key.
     */
    private function grantAllToSuperAdmin(): void
    {
        $roleId = DB::table('system_roles')->where('role_code', 'super_admin')->value('id');
        if (! $roleId) {
            return;
        }

        $now = now();
        $permissions = DB::table('system_permissions')->pluck('id');
        $rows = $permissions->map(fn ($pid) => [
            'role_id' => $roleId,
            'permission_id' => $pid,
            'created_at' => $now,
            'updated_at' => $now,
        ])->all();

        if ($rows) {
            DB::table('role_permission')->upsert(
                $rows,
                ['role_id', 'permission_id'],
                ['updated_at']
            );
        }
    }
}
