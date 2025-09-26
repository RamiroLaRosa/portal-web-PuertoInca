<?php

namespace App\Http\Middleware;

use App\Models\Modulo;
use App\Models\Permiso;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckModulePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $module): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors('Debes iniciar sesión.');
        }

        // agregar short_name para futuro
        $modulo = Modulo::where('short_name', $module)->first();
        if (!$modulo) {
            return abort(400, 'El módulo no existe');
        }
        // Verificar si existe permiso activo para el rol del usuario y este módulo
        $tienePermiso = Permiso::where('id_rol', $user->rol_id)
            ->where('id_modulo', $modulo->id)
            ->where('is_active', 1)
            ->exists();

        if (!$tienePermiso) {
            Auth::logout();
            Session::invalidate();
            Session::regenerateToken();
            // return abort(403, 'No tienes permisos para acceder a este módulo');
            return redirect()
                ->route('login')
                ->withErrors(['login' => 'Tu sesión ha sido cerrada porque no tienes permisos para acceder a este módulo.']);
        }

        return $next($request);
    }
}
