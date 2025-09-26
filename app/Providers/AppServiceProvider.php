<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\LinkInstitucional;
use App\Models\ProgramasEstudio;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('header', function ($view) {
            $links = LinkInstitucional::active()
                ->orderBy('id')
                ->get(['nombre', 'enlace']);

            // Programas activos para el menú
            $programasMenu = ProgramasEstudio::where('is_active', 1)
                ->orderBy('id')
                ->get(['id', 'nombre']);

            $view->with([
                'linksInstitucionales' => $links,
                'programasMenu'        => $programasMenu,
            ]);
        });

        View::composer('include.sidebar', function ($view) {
            if (Auth::check()) {
                $userId = Auth::user()->id;

                $datalist = Usuario::join('roles as r', 'usuarios.rol_id', '=', 'r.id')
                    ->join('permisos as p', 'r.id', '=', 'p.id_rol')
                    ->join('modulos as m', 'p.id_modulo', '=', 'm.id')
                    ->select(
                        'r.id as id_rol',
                        'r.nombre as nombre_rol',
                        'm.id as id_modulo',
                        'm.nombre as nombre_modulo',
                        'p.is_active as permiso',
                        DB::raw('IF(p.is_active = 1, "Activo", "Inactivo") as estado_permiso')
                    )
                    ->where('usuarios.id', $userId)
                    ->get();

                $view->with('datalist', $datalist);
            } else {
                // Si no hay usuario logueado, sidebar vacío
                $view->with('datalist', collect());
            }
        });
    }
}
