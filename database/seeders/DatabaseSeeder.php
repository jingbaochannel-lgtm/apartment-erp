<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Top-level seeder. Runs the structural seeders that ship a usable
 * Apartment ERP instance: the default branch, RBAC catalog, a super-
 * admin login and the utility-type catalog. Idempotent — every seeder
 * upserts on natural keys.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ApartmentProfileSeeder::class,
            SystemPermissionSeeder::class,
            SystemRoleSeeder::class,
            SystemUserSeeder::class,
            UtilityTypeSeeder::class,
        ]);
    }
}
