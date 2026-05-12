<?php

namespace App\Models\Concerns;

use App\Observers\AuditingObserver;

/**
 * Models that opt-in write rows into `audit_logs` whenever they are
 * created, updated or deleted. The actual logging logic lives in
 * `App\Observers\AuditingObserver`.
 */
trait Auditable
{
    public static function bootAuditable(): void
    {
        static::observe(AuditingObserver::class);
    }
}
