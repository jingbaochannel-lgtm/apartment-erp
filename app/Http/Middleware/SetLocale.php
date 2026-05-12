<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Resolves the active app locale from (in order of precedence):
 *
 *   1. `?lang=km` query string  (so deep-links + email links work)
 *   2. `session('locale')`      (set by the AJAX language switcher)
 *   3. `config('app.locale')`   (system default)
 *
 * Persists the result back into the session so subsequent requests
 * keep the same language without a refresh.
 */
class SetLocale
{
    /** Locales the UI ships translations for. */
    public const SUPPORTED = ['en', 'km'];

    public function handle(Request $request, Closure $next)
    {
        $candidate = $request->query('lang')
            ?: $request->session()->get('locale')
            ?: config('app.locale');

        if (! in_array($candidate, self::SUPPORTED, true)) {
            $candidate = config('app.locale');
        }

        app()->setLocale($candidate);
        $request->session()->put('locale', $candidate);

        return $next($request);
    }
}
