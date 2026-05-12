<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Creates a default property owner and a single demo branch so the
 * admin UI has something to render on first boot. Idempotent — uses
 * `upsert` keyed on the natural-key columns.
 */
class ApartmentProfileSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('property_owners')->upsert([
            [
                'owner_code' => 'OWN-DEFAULT',
                'name' => 'Default Property Owner',
                'phone' => null,
                'email' => null,
                'address' => null,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['owner_code'], ['name', 'status', 'updated_at']);

        $ownerId = DB::table('property_owners')->where('owner_code', 'OWN-DEFAULT')->value('id');

        DB::table('apartment_profiles')->upsert([
            [
                'property_owner_id' => $ownerId,
                'apartment_code' => 'HQ',
                'name' => 'Head Office',
                'address' => 'Phnom Penh, Cambodia',
                'phone' => null,
                'email' => null,
                'currency' => 'USD',
                'timezone' => 'Asia/Phnom_Penh',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['apartment_code'], ['name', 'address', 'status', 'updated_at']);
    }
}
