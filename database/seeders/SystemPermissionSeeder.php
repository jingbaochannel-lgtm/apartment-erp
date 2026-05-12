<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Seeds `{module}.{verb}` permissions for every CRUD module defined in
 * `scripts/controller_definitions.php`. The verbs (view / create / edit /
 * delete) mirror the BaseCrudController::actionPermissions map, so a
 * super-admin role can grant access by listing module prefixes.
 */
class SystemPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $defs = $this->loadDefinitions();
        $verbs = ['view', 'create', 'edit', 'delete'];

        $now = now();
        $rows = [];

        foreach ($defs as $slug => $def) {
            $module = str_replace('-', '_', (string) $slug);
            $singular = $def['singular'] ?? Str::headline($module);
            foreach ($verbs as $verb) {
                $rows[] = [
                    'permission_code' => "{$module}.{$verb}",
                    'module' => $module,
                    'action' => $verb,
                    'name' => ucfirst($verb).' '.$singular,
                    'description' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DB::table('system_permissions')->upsert(
            $rows,
            ['permission_code'],
            ['module', 'action', 'name', 'updated_at']
        );

        $this->command?->info('Seeded '.count($rows).' system permissions.');
    }

    /**
     * Pull the canonical CRUD module list from the generator definitions
     * so this seeder stays automatically in sync with the controllers.
     */
    private function loadDefinitions(): array
    {
        $path = base_path('scripts/controller_definitions.php');
        if (! is_file($path)) {
            return [];
        }

        return require $path;
    }
}
