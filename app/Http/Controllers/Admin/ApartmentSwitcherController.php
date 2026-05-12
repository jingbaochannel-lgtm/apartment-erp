<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApartmentProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Lets a signed-in user pick which "branch" (`apartment_profiles` row)
 * the rest of the admin UI is scoped to. The choice is persisted in
 * the session and consumed by `App\Models\Scopes\ApartmentScope`.
 */
class ApartmentSwitcherController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'apartment_profile_id' => ['required', 'integer'],
        ]);

        $apartmentId = (int) $request->input('apartment_profile_id');

        $exists = ApartmentProfile::query()
            ->whereKey($apartmentId)
            ->exists();

        abort_unless($exists, 404);

        $request->session()->put('current_apartment_id', $apartmentId);
        flash()->success(__('app.flash.branch_changed'));

        return back();
    }
}
