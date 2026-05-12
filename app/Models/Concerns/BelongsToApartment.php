<?php

namespace App\Models\Concerns;

use App\Models\ApartmentProfile;
use App\Models\Scopes\ApartmentScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Multi-branch trait. Each "apartment_profile" row IS a branch:
 * a single tenant in our multi-tenant deployment owns multiple
 * apartments/buildings, each with its own data set. This trait:
 *
 *  1. Adds a global ApartmentScope so queries are automatically
 *     filtered to the user's currently-selected branch.
 *  2. Auto-fills `apartment_profile_id` on create when the model
 *     has the column and a current branch is selected.
 *  3. Exposes a `apartmentProfile()` BelongsTo relation.
 *
 * Tables that link to a branch keep the legacy column name
 * `apartment_profile_id`; the constants below let callers reference
 * it without sprinkling string literals everywhere.
 */
trait BelongsToApartment
{
    public const APARTMENT_FK = 'apartment_profile_id';

    public static function bootBelongsToApartment(): void
    {
        static::addGlobalScope(new ApartmentScope);

        static::creating(function ($model) {
            if (
                ! $model->getAttribute(self::APARTMENT_FK)
                && session()->has('current_apartment_id')
            ) {
                $model->setAttribute(self::APARTMENT_FK, session('current_apartment_id'));
            }
        });
    }

    public function apartmentProfile(): BelongsTo
    {
        return $this->belongsTo(ApartmentProfile::class, self::APARTMENT_FK);
    }
}
