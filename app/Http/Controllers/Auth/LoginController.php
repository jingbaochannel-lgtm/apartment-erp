<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Minimal session login flow. Authenticates against the standard
 * Laravel `users` table seeded by `SystemUserSeeder` (default login
 * `admin@apartment-erp.local` / `password`). After login the user
 * is redirected to the admin dashboard.
 */
class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, (bool) $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => __('app.auth.failed')]);
        }

        $request->session()->regenerate();
        flash()->success(__('app.flash.logged_in'));

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        flash()->success(__('app.flash.logged_out'));

        return redirect()->route('login');
    }
}
