<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\sidebar\SidebarController;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PageAccessRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $id_module): Response
    {
        $objeto = new SidebarController();

        $result = $objeto->ConsultaAccessRouteModule($id_module);
        // Verifica si la página está habilitada
        // if ($result[0]->estado === '1') {
        if (count($result) > 0) {
        $response = $next($request);
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Cache-Control', 'post-check=0, pre-check=0', false);
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');
        return  $response;
        
        }else {

            if (Auth::User()->usertype_id == "1") {
                $ruta = 'home.adm.dashboard';// Redirige a la página de inicio si el rol no coincide
            }else  if (Auth::User()->usertype_id == "2") {
                $ruta = 'home.docente.index';// Redirige a la página de inicio si el rol no coincide
            }else  if (Auth::User()->usertype_id == "3") {
                $ruta = 'home.student.index';// Redirige a la página de inicio si el rol no coincide
            }
        }

        return redirect()->route($ruta);;

    }
}
