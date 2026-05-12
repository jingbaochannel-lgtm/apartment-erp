<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Backs the no-refresh language switcher in the navbar.
 *
 *   POST  /admin/language          { "locale": "km" }   AJAX
 *   GET   /admin/language/{locale}                       fallback link
 *
 * On success we update the session, app locale and return a JSON
 * payload containing the freshly-translated strings the front-end uses
 * to swap labels (DataTables, SweetAlert2, sidebar menu) on the fly.
 */
class LanguageController extends Controller
{
    public function switch(Request $request, ?string $locale = null): JsonResponse
    {
        $locale = $locale
            ?? $request->input('locale')
            ?? $request->input('lang');

        if (! in_array($locale, SetLocale::SUPPORTED, true)) {
            return response()->json([
                'ok' => false,
                'message' => 'Unsupported locale',
                'supported' => SetLocale::SUPPORTED,
            ], 422);
        }

        $request->session()->put('locale', $locale);
        app()->setLocale($locale);

        return response()->json([
            'ok' => true,
            'locale' => $locale,
            'translations' => [
                'app' => trans('app'),
            ],
        ]);
    }
}
