<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Global scope that constrains all queries on a `BelongsToApartment`
 * model to the branch currently selected in `session('current_apartment_id')`.
 *
 * If no branch is selected (CLI, queue jobs, super-admin "all branches"
 * mode) the scope is a no-op so every row stays visible. Lookup tables
 * that should always be cross-branch simply skip the trait.
 *
 * Use the `withoutApartmentScope()` macro to opt out for a single query
 * (e.g. branch switcher dropdown, system-wide reports).
 */
class ApartmentScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $apartmentId = session('current_apartment_id');
        if (! $apartmentId) {
            return;
        }

        $builder->where(
            $model->getTable().'.apartment_profile_id',
            $apartmentId
        );
    }

    public function extend(Builder $builder): void
    {
        $builder->macro('withoutApartmentScope', function (Builder $b) {
            return $b->withoutGlobalScope(self::class);
        });
    }
}
