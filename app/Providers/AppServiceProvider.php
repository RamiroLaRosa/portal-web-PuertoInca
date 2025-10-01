<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\LinkInstitucional;
use App\Models\ProgramasEstudio;
use App\Models\Usuario;
use App\Models\Color;
use App\Models\Logo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
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

        View::composer(['header', 'include.header'], function ($view) {
            $url = Cache::remember('site_logo_url', 3600, function () {
                $logo = Logo::where('is_active', 1)->latest('id')->first();

                if (!$logo || empty($logo->imagen)) {
                    return asset('images/Logo_Silfer.png'); // fallback
                }

                // En BD guardas "images/2025....png"
                return Str::startsWith($logo->imagen, ['http://', 'https://'])
                    ? $logo->imagen
                    : asset(ltrim($logo->imagen, '/')); // => /images/2025...png
            });

            $view->with('siteLogoUrl', $url);
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

        View::composer('*', function ($view) {
            $colores = Color::whereIn('clave', [
                'color-primario-p1',
                'color-primario-p2',
                'color-primario-p3',
                'color-secundario-s1',
                'color-neutral'
            ])->pluck('valor', 'clave')->toArray();

            $defaults = [
                'color-primario-p1' => '#00264B',
                'color-primario-p2' => '#1A4FD3',
                'color-primario-p3' => '#4A84F7',
                'color-secundario-s1' => '#E27227',
                'color-neutral' => '#DDE3E8',
            ];

            $colores = array_merge($defaults, $colores);

            $view->with('colores', $colores);
        });


    }
}
