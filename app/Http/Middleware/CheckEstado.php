<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckEstado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::User()->estado === 1) {
            $response = $next($request);

            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Cache-Control', 'post-check=0, pre-check=0', false);
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
            return  $response;
        }

        // Si el usuario no está activo
        Session::flush();
        Auth::logout(); // Cerrar sesión si el usuario no está activo
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
