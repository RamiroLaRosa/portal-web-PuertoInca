<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTypeUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle($request, Closure $next, $role1, $role2, $role3, $role4): Response
    {

        // Verifica si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Verifica si el rol del usuario coincide con el rol especificado
        if (Auth::User()->usertype_id == $role1 || Auth::User()->usertype_id == $role2 ||
             Auth::User()->usertype_id == $role3 || Auth::User()->usertype_id == $role4) {

            $response = $next($request);

            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Cache-Control', 'post-check=0, pre-check=0', false);
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
            return  $response;

        }else {

            $idusertype = Auth::User()->usertype_id;

            if ($idusertype == "1") {
                $ruta = 'home.adm.dashboard';// Redirige a la página de inicio si el rol no coincide
            }else  if ($idusertype == "2" || $idusertype == "4" || $idusertype == "6" || $idusertype == "7") {
                $ruta = 'home.docente.index';// Redirige a la página de inicio si el rol no coincide
            }else  if ($idusertype == "3" || $idusertype == "5" ) {
                $ruta = 'home.student.index';// Redirige a la página de inicio si el rol no coincide
            }
        }

        return redirect()->route($ruta);

    }
}
