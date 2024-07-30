<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLanguageBasedOnCountry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasSession() && $request->session()->get('country_name', false)) {
            return $next($request);
        }

        try {
            $country_name = $request->user()?->country?->name ?? auth('customer')->user()?->distributor?->country?->name;

            $request->session()->put('country_name', $country_name);

            switch ($country_name) {
                case 'Germany':
                    app()->setLocale(
                        locale: 'de'
                    );
                    break;
                case 'Austria':
                    app()->setLocale(
                        locale: 'de'
                    );
                    break;
                case 'Switzerland':
                    app()->setLocale(
                        locale: 'de'
                    );
                    break;
                case 'Luxembourg':
                    app()->setLocale(
                        locale: 'de'
                    );
                    break;

                default:
                    break;
            }
        } catch (\Throwable $th) {
            // throw $th;
        }
        return $next($request);
    }
}
