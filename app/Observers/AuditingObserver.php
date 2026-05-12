<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Writes a row into `audit_logs` for every create/update/delete event
 * on models that use `App\Models\Concerns\Auditable`.
 */
class AuditingObserver
{
    public function created(Model $model): void
    {
        $this->record('created', $model, [], $model->getAttributes());
    }

    public function updated(Model $model): void
    {
        $this->record('updated', $model, $model->getOriginal(), $model->getChanges());
    }

    public function deleted(Model $model): void
    {
        $this->record('deleted', $model, $model->getOriginal(), []);
    }

    protected function record(string $action, Model $model, array $old, array $new): void
    {
        if (! \Schema::hasTable('audit_logs')) {
            return;
        }

        $request = request();

        AuditLog::create([
            'user_id' => Auth::id(),
            'module' => class_basename($model),
            'action' => $action,
            'auditable_type' => get_class($model),
            'auditable_id' => $model->getKey(),
            'old_values' => $old ?: null,
            'new_values' => $new ?: null,
            'ip_address' => $request?->ip(),
            'user_agent' => substr((string) $request?->userAgent(), 0, 255) ?: null,
            'performed_at' => now(),
        ]);
    }
}
