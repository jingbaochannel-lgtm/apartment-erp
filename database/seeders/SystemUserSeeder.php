<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Creates a default super-admin login. Credentials live in the standard
 * Laravel `users` table (used for Sanctum / session auth) AND a mirror
 * row in `system_users` so downstream modules referencing system_user_id
 * resolve cleanly.
 */
class SystemUserSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Laravel auth table.
        DB::table('users')->upsert([
            [
                'name' => 'Apartment ERP Admin',
                'email' => 'admin@apartment-erp.local',
                'email_verified_at' => $now,
                'password' => Hash::make('password'),
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['email'], ['name', 'password', 'updated_at']);

        // Mirror row in the ERP-specific table.
        DB::table('system_users')->upsert([
            [
                'name' => 'Apartment ERP Admin',
                'username' => 'admin',
                'email' => 'admin@apartment-erp.local',
                'password' => Hash::make('password'),
                'user_type' => 'super_admin',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['username'], ['name', 'email', 'user_type', 'status', 'updated_at']);

        $userId = DB::table('system_users')->where('username', 'admin')->value('id');
        $roleId = DB::table('system_roles')->where('role_code', 'super_admin')->value('id');

        if ($userId && $roleId) {
            DB::table('user_role')->upsert([
                [
                    'user_id' => $userId,
                    'role_id' => $roleId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ], ['user_id', 'role_id'], ['updated_at']);
        }

        $this->command?->info('Default admin user: admin / password');
    }
}
