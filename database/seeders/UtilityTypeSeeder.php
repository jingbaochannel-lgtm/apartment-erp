<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Default utility types (electricity / water / gas / internet) so the
 * meter-reading workflow has a starting catalog. Skipped if the table
 * doesn't exist (e.g. partial migration in tests).
 */
class UtilityTypeSeeder extends Seeder
{
    public function run(): void
    {
        if (! Schema::hasTable('utility_types')) {
            return;
        }

        $now = now();
        $rows = [
            ['utility_code' => 'ELEC',  'name' => 'Electricity', 'unit' => 'kWh',   'billing_method' => 'meter'],
            ['utility_code' => 'WATER', 'name' => 'Water',       'unit' => 'm³',    'billing_method' => 'meter'],
            ['utility_code' => 'GAS',   'name' => 'Gas',         'unit' => 'm³',    'billing_method' => 'meter'],
            ['utility_code' => 'INET',  'name' => 'Internet',    'unit' => 'month', 'billing_method' => 'flat'],
        ];

        $payload = collect($rows)->map(fn ($r) => array_merge($r, [
            'status' => 'active',
            'created_at' => $now,
            'updated_at' => $now,
        ]))->all();

        DB::table('utility_types')->upsert(
            $payload,
            ['utility_code'],
            ['name', 'unit', 'billing_method', 'status', 'updated_at']
        );
    }
}
