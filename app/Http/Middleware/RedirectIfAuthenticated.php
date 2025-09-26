<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                if (Auth::User()->usertype_id == "1") {
                    return redirect(RouteServiceProvider::HOMEADM); // Redirige a la página de inicio si el rol no coincide
                } else if (Auth::User()->usertype_id == "2") {
                    return redirect(RouteServiceProvider::HOMEDOCENTE); // Redirige a la página de inicio si el rol no coincide
                } else if (Auth::User()->usertype_id == "3") {
                    return redirect(RouteServiceProvider::HOMESTUDENT); // Redirige a la página de inicio si el rol no coincide
                }
            }
        }

        return $next($request);
    }
}
