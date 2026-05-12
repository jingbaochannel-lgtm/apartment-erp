<?php

/**
 * One-shot generator that produces a Model class file for every table
 * defined in the apartment ERP migration. The output is intentionally
 * minimal — fillable columns, casts and a couple of relations — so the
 * generic CRUD controller can use any model without further hand-edit.
 *
 * Idempotent: re-running overwrites only the *generated* model files.
 */

declare(strict_types=1);

const APP_NAMESPACE = 'App\\Models';

/**
 * Map of table => model class definition.
 *
 * 'fillable'        : column names suitable for $request->only().
 * 'casts'           : column => Eloquent cast type.
 * 'belongs_to'      : relation name => [related model, fk column].
 * 'apartment_aware' : table has `apartment_profile_id` -> use BelongsToApartment.
 * 'soft_deletes'    : table has `deleted_at` -> use SoftDeletes.
 * 'audit'           : opt into the Auditable trait.
 * 'no_timestamps'   : pivot tables that only have `created_at`/`updated_at`.
 */
$tables = require __DIR__.'/model_definitions.php';

$dryRun = in_array('--dry-run', $argv, true);
$only = null;
foreach ($argv as $a) {
    if (str_starts_with($a, '--only=')) {
        $only = substr($a, 7);
    }
}

$base = realpath(__DIR__.'/..').'/app/Models';
if (! is_dir($base)) {
    mkdir($base, 0o755, true);
}

foreach ($tables as $table => $def) {
    if ($only && $only !== $table) {
        continue;
    }
    $class = $def['class'];
    $code = renderModel($table, $def);
    $path = $base.'/'.$class.'.php';
    if ($dryRun) {
        echo "WOULD WRITE: $path\n";

        continue;
    }
    file_put_contents($path, $code);
    echo "wrote $path\n";
}

function renderModel(string $table, array $def): string
{
    $class = $def['class'];
    $useUser = ! empty($def['is_user']);
    $useAuditable = ! empty($def['audit']);
    $useApartment = ! empty($def['apartment_aware']);
    $useSoftDeletes = ! empty($def['soft_deletes']);
    $useNotifiable = ! empty($def['is_user']);

    $uses = [];
    if ($useUser) {
        $uses[] = 'use Illuminate\\Foundation\\Auth\\User as Authenticatable;';
        $uses[] = 'use Illuminate\\Notifications\\Notifiable;';
    } else {
        $uses[] = 'use Illuminate\\Database\\Eloquent\\Model;';
    }
    if ($useSoftDeletes) {
        $uses[] = 'use Illuminate\\Database\\Eloquent\\SoftDeletes;';
    }
    if ($useAuditable) {
        $uses[] = 'use App\\Models\\Concerns\\Auditable;';
    }
    if ($useApartment) {
        $uses[] = 'use App\\Models\\Concerns\\BelongsToApartment;';
    }
    foreach ($def['belongs_to'] ?? [] as $relation => $info) {
        $relatedClass = $info[0];
        if ($relatedClass !== $class) {
            $uses[] = 'use App\\Models\\'.$relatedClass.';';
        }
    }
    if (! empty($def['has_many'])) {
        $uses[] = 'use Illuminate\\Database\\Eloquent\\Relations\\HasMany;';
    }
    if (! empty($def['belongs_to'])) {
        $uses[] = 'use Illuminate\\Database\\Eloquent\\Relations\\BelongsTo;';
    }
    if (! empty($def['belongs_to_many'])) {
        $uses[] = 'use Illuminate\\Database\\Eloquent\\Relations\\BelongsToMany;';
    }
    $uses = array_values(array_unique($uses));
    sort($uses);

    $traits = [];
    if ($useNotifiable) {
        $traits[] = 'Notifiable';
    }
    if ($useSoftDeletes) {
        $traits[] = 'SoftDeletes';
    }
    if ($useAuditable) {
        $traits[] = 'Auditable';
    }
    if ($useApartment) {
        $traits[] = 'BelongsToApartment';
    }
    $traitLine = $traits ? '    use '.implode(', ', $traits).";\n\n" : '';

    $extends = $useUser ? 'Authenticatable' : 'Model';

    $tableProp = "    protected \$table = '{$table}';\n";

    $fillable = $def['fillable'] ?? [];
    sort($fillable);
    $fillableProp = "    protected \$fillable = [\n";
    foreach ($fillable as $col) {
        $fillableProp .= "        '{$col}',\n";
    }
    $fillableProp .= "    ];\n";

    $casts = $def['casts'] ?? [];
    $castsProp = '';
    if ($casts) {
        $castsProp = "\n    protected \$casts = [\n";
        foreach ($casts as $col => $type) {
            $castsProp .= "        '{$col}' => '{$type}',\n";
        }
        $castsProp .= "    ];\n";
    }

    $hidden = $def['hidden'] ?? [];
    $hiddenProp = '';
    if ($hidden) {
        $hiddenProp = "\n    protected \$hidden = [\n";
        foreach ($hidden as $col) {
            $hiddenProp .= "        '{$col}',\n";
        }
        $hiddenProp .= "    ];\n";
    }

    $relationsCode = '';
    foreach ($def['belongs_to'] ?? [] as $rel => $info) {
        [$related, $fk] = $info;
        $relationsCode .= "\n    public function {$rel}(): BelongsTo\n    {\n        return \$this->belongsTo({$related}::class, '{$fk}');\n    }\n";
    }
    foreach ($def['has_many'] ?? [] as $rel => $info) {
        [$related, $fk] = $info;
        $relationsCode .= "\n    public function {$rel}(): HasMany\n    {\n        return \$this->hasMany(\\App\\Models\\{$related}::class, '{$fk}');\n    }\n";
    }
    foreach ($def['belongs_to_many'] ?? [] as $rel => $info) {
        [$related, $pivot, $fk, $relatedFk] = $info;
        $relationsCode .= "\n    public function {$rel}(): BelongsToMany\n    {\n        return \$this->belongsToMany(\\App\\Models\\{$related}::class, '{$pivot}', '{$fk}', '{$relatedFk}');\n    }\n";
    }

    $usesBlock = implode("\n", $uses);

    $namespace = APP_NAMESPACE;

    $code = <<<PHP
<?php

namespace {$namespace};

{$usesBlock}

class {$class} extends {$extends}
{
{$traitLine}{$tableProp}
{$fillableProp}{$castsProp}{$hiddenProp}{$relationsCode}}
PHP;

    return $code."\n";
}
