<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // First check URL parameter, then session, then default
        $locale = $request->get('lang', Session::get('locale', config('app.locale')));

        // Check if locale is supported
        $availableLocales = config('app.available_locales');
        if ($availableLocales && is_array($availableLocales)) {
            $supportedLocales = array_keys($availableLocales);
        } else {
            $supportedLocales = ['en']; // Default fallback
        }

        if (in_array($locale, $supportedLocales)) {
            App::setLocale($locale);
            // Store in session for subsequent requests
            Session::put('locale', $locale);
        } else {
            // Fallback to English if locale is not supported
            App::setLocale('en');
            Session::put('locale', 'en');
        }

        return $next($request);
    }
}
