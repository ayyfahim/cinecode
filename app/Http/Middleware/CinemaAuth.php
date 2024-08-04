<?php

namespace App\Http\Middleware;

use App\Models\Cinema;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CinemaAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->has('c')) {
            return abort(401, 'No hash detected.');
        }

        if (!$request->session()->has('unique_hash') || $request->session()->get('unique_hash') !== $request->c) {

            $cinema = Cinema::select('name', 'unique_hash', 'city_name')->where('unique_hash', $request->c)->count();

            if ($cinema == 0) {
                return abort(401, 'Unable to detect hash.');
            }

            $request->session()->put('unique_hash', $request->c);
            // $request->session()->put('cinema', $cinema);
        }

        return $next($request);
    }
}
