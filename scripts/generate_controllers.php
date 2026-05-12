<?php

/**
 * One-shot generator that emits one CRUD controller per entry in
 * `scripts/controller_definitions.php`. Each generated controller is a
 * thin subclass of `App\Http\Controllers\Admin\BaseCrudController` that
 * overrides only the bits that are module-specific (model class,
 * permission prefix, columns, fields, validation rules).
 *
 * Run from the project root:
 *
 *     php scripts/generate_controllers.php
 *
 * Idempotent — overwrites generated files on each run.
 */

declare(strict_types=1);

$root = dirname(__DIR__);
$defs = require __DIR__.'/controller_definitions.php';
$outDir = $root.'/app/Http/Controllers/Admin';

if (! is_dir($outDir)) {
    mkdir($outDir, 0755, true);
}

$count = 0;
foreach ($defs as $slug => $def) {
    $php = renderController($slug, $def);
    file_put_contents("$outDir/{$def['class']}.php", $php);
    $count++;
}

echo "Generated $count controllers in $outDir\n";

/**
 * Stamps out a controller given a slug and its config block. Handles
 * the field-tuple language used in `controller_definitions.php` and
 * collapses the result into a tidy single-class file aligned with the
 * `BaseCrudController` API.
 */
function renderController(string $slug, array $def): string
{
    $class = $def['class'];
    $model = $def['model'];
    $singular = addslashes($def['singular']);
    $plural = addslashes($def['plural']);
    $with = $def['with'] ?? [];
    $searchable = $def['searchable'] ?? [];
    $columns = $def['columns'] ?? [];
    $fields = $def['fields'] ?? [];
    $extraRules = $def['extra_rules'] ?? [];
    $beforeSave = $def['before_save'] ?? null;
    $readOnly = $def['read_only'] ?? false;

    $permissionModule = str_replace('-', '_', $slug);

    $columnsPhp = exportArray($columns, 8);
    $searchablePhp = exportSimpleArray($searchable);
    $withPhp = exportSimpleArray($with);

    $fieldStatements = [];
    $rules = [];
    foreach ($fields as $f) {
        [$type, $name, $label] = [$f[0], $f[1], $f[2]];
        $required = $f[3] ?? false;
        $fieldStatements[] = renderFieldStatement($f);
        $rules[$name] = renderRule($type, $required);
    }

    foreach ($extraRules as $name => $rule) {
        $rules[$name] = $rule;
    }

    $rulesPhp = "[\n";
    foreach ($rules as $name => $r) {
        $rulesPhp .= "            '$name' => $r,\n";
    }
    $rulesPhp .= '        ]';

    if (! $fieldStatements) {
        $fieldsPhp = '[]';
    } else {
        $fieldsPhp = "[\n";
        foreach ($fieldStatements as $stmt) {
            $fieldsPhp .= "            $stmt,\n";
        }
        $fieldsPhp .= '        ]';
    }

    $beforeSavePhp = '';
    if ($beforeSave) {
        $beforeSavePhp = "\n    protected function beforeSave(array \$data, Request \$request, ?\\Illuminate\\Database\\Eloquent\\Model \$record = null): array\n".
                       "    {\n".
                       "        $beforeSave\n".
                       "        return \$data;\n".
                       "    }\n";
    }

    $readOnlyProp = '';
    if ($readOnly) {
        $readOnlyProp = "    protected bool \$readOnly = true;\n\n";
    }

    return <<<PHP
<?php

namespace App\Http\Controllers\Admin;

use App\Models\\{$model};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Auto-generated CRUD controller for {$plural}.
 *
 * Edit `scripts/controller_definitions.php` and re-run
 * `php scripts/generate_controllers.php` to regenerate.
 */
class {$class} extends BaseCrudController
{
    protected string \$modelClass = {$model}::class;
    protected string \$routeSlug = '{$slug}';
    protected ?string \$permissionModule = '{$permissionModule}';
    protected string \$singular = '{$singular}';
    protected string \$plural = '{$plural}';
    protected array \$with = {$withPhp};
    protected array \$searchable = {$searchablePhp};
    protected array \$columns = {$columnsPhp};

{$readOnlyProp}    protected function fields(): array
    {
        return {$fieldsPhp};
    }

    protected function rules(?Model \$record = null): array
    {
        return {$rulesPhp};
    }
{$beforeSavePhp}}
PHP;
}

/** Translate the array-tuple into a PHP CrudField factory call. */
function renderFieldStatement(array $f): string
{
    [$type, $name, $label] = [$f[0], $f[1], $f[2]];
    $required = $f[3] ?? false;
    $extra = $f[4] ?? null;
    $reqArg = $required ? 'true' : 'false';

    switch ($type) {
        case 'text':
            return "\\App\\Support\\CrudField::text('$name', '".addslashes($label)."', $reqArg)";
        case 'email':
            return "\\App\\Support\\CrudField::email('$name', '".addslashes($label)."', $reqArg)";
        case 'password':
            return "\\App\\Support\\CrudField::password('$name', '".addslashes($label)."', $reqArg)";
        case 'number':
            return "\\App\\Support\\CrudField::number('$name', '".addslashes($label)."', $reqArg)";
        case 'decimal':
            return "\\App\\Support\\CrudField::decimal('$name', '".addslashes($label)."', $reqArg)";
        case 'date':
            return "\\App\\Support\\CrudField::date('$name', '".addslashes($label)."', $reqArg)";
        case 'datetime':
            return "\\App\\Support\\CrudField::datetime('$name', '".addslashes($label)."', $reqArg)";
        case 'time':
            return "\\App\\Support\\CrudField::time('$name', '".addslashes($label)."', $reqArg)";
        case 'textarea':
            $rows = $extra ?: 3;

            return "\\App\\Support\\CrudField::textarea('$name', '".addslashes($label)."', $reqArg, $rows)";
        case 'checkbox':
            return "\\App\\Support\\CrudField::checkbox('$name', '".addslashes($label)."')";
        case 'select':
            $opts = $extra;
            if (! is_string($opts)) {
                throw new RuntimeException("Select field $name must include options string");
            }
            $optionsExpr = renderSelectOptions($opts);

            return "\\App\\Support\\CrudField::select('$name', '".addslashes($label)."', $optionsExpr, $reqArg)";
        default:
            throw new RuntimeException("Unknown field type: $type");
    }
}

/** Build a Laravel validation rule string for the given field type. */
function renderRule(string $type, bool $required): string
{
    $req = $required ? "'required'" : "'nullable'";

    return match ($type) {
        'email' => "[$req, 'email', 'max:191']",
        'password' => "[$req, 'string', 'min:6']",
        'number' => "[$req, 'integer']",
        'decimal' => "[$req, 'numeric']",
        'date' => "[$req, 'date']",
        'datetime' => "[$req, 'date']",
        'time' => "[$req, 'string', 'max:20']",
        'checkbox' => "[$req, 'boolean']",
        'textarea' => "[$req, 'string']",
        'select' => "[$req, 'string', 'max:191']",
        default => "[$req, 'string', 'max:191']",
    };
}

/** Convert the option marker (`@status_default`) or model-name reference to PHP. */
function renderSelectOptions(string $expr): string
{
    if ($expr === '@status_default') {
        return "['active' => 'Active', 'inactive' => 'Inactive']";
    }
    if (str_starts_with($expr, '[')) {
        return $expr;
    }

    return "static::options(\\App\\Models\\{$expr}::class)";
}

/** var_export-style pretty-printer for column arrays. */
function exportArray(array $arr, int $indent): string
{
    if (! $arr) {
        return '[]';
    }
    $pad = str_repeat(' ', $indent);
    $out = "[\n";
    foreach ($arr as $k => $v) {
        $out .= $pad."'".addslashes((string) $k)."' => '".addslashes((string) $v)."',\n";
    }
    $out .= str_repeat(' ', max(0, $indent - 4)).']';

    return $out;
}

function exportSimpleArray(array $arr): string
{
    if (! $arr) {
        return '[]';
    }

    return "['".implode("', '", array_map(fn ($v) => addslashes((string) $v), $arr))."']";
}
