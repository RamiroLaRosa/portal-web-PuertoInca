<?php

namespace App\Http\Middleware;

use App\Http\Controllers\paggeAccess\PageAccessController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class PageAccessTramireDocumentario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Obtén la hora actual del servidor
        $objeto = new PageAccessController();

        $statusmodule = $objeto->estadomodulotramitedocumentario();
        // Verifica si la página está habilitada
        if ($statusmodule) {
            // Si la hora está dentro del rango, permite el acceso al layout
            view()->share('module', true);
            $response = $next($request);
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Cache-Control', 'post-check=0, pre-check=0', false);
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
            return $response;
        }else {
            view()->share('module', false);
            return redirect()->route('page.inactivo.tramite');
        }
    }

}
