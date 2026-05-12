<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;

/**
 * Resolves a "column path" (`name`, `building.name`, `tenant.full_name`)
 * against a Model instance and produces an HTML-safe string for the
 * generic CRUD index / DataTables view.
 *
 * Booleans render as Yes/No badges, dates as ISO strings, statuses as
 * coloured Bootstrap 5 pill badges so every controller gets sensible
 * defaults without bespoke Blade.
 */
class ColumnRenderer
{
    /** Status values that should show in green ("good"). */
    private const STATUS_OK = [
        'active', 'completed', 'paid', 'approved', 'received',
        'verified', 'issued', 'sent', 'closed', 'resolved',
    ];

    /** Status values that should show in red ("bad"). */
    private const STATUS_BAD = [
        'inactive', 'cancelled', 'rejected', 'overdue',
        'failed', 'expired', 'damaged', 'unpaid',
    ];

    /** Status values that should show in yellow ("warn"). */
    private const STATUS_WARN = [
        'pending', 'draft', 'open', 'partial',
        'in_progress', 'scheduled', 'reserved',
    ];

    public static function render(Model $row, string $column): string
    {
        if ($column === 'actions') {
            return '';
        }

        $value = self::resolve($row, $column);

        if ($value === null || $value === '') {
            return '<span class="text-muted">—</span>';
        }

        if (is_bool($value)) {
            return $value
                ? '<span class="badge bg-success">'.__('app.actions.yes').'</span>'
                : '<span class="badge bg-secondary">'.__('app.actions.no').'</span>';
        }

        if ($value instanceof \DateTimeInterface) {
            return e($value->format('Y-m-d H:i'));
        }

        if (str_ends_with($column, 'status') || $column === 'status') {
            return self::renderStatus((string) $value);
        }

        if (is_array($value) || is_object($value)) {
            return e(json_encode($value, JSON_UNESCAPED_UNICODE));
        }

        return e((string) $value);
    }

    public static function resolve(Model $row, string $column): mixed
    {
        if (! str_contains($column, '.')) {
            return $row->getAttribute($column);
        }

        [$relation, $field] = explode('.', $column, 2);
        $related = $row->getRelationValue($relation) ?? $row->{$relation};

        if ($related === null) {
            return null;
        }

        return self::resolve($related, $field);
    }

    public static function renderStatus(string $status): string
    {
        $normalised = strtolower($status);
        $class = 'bg-secondary';

        if (in_array($normalised, self::STATUS_OK, true)) {
            $class = 'bg-success';
        } elseif (in_array($normalised, self::STATUS_BAD, true)) {
            $class = 'bg-danger';
        } elseif (in_array($normalised, self::STATUS_WARN, true)) {
            $class = 'bg-warning text-dark';
        }

        return '<span class="badge '.$class.'">'.e(__('app.statuses.'.$normalised, [], null) ?: $status).'</span>';
    }
}
