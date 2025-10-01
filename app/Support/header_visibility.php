<?php

use App\Models\Header;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Models\Submodulo;

if (! function_exists('header_on')) {
    /**
     * Devuelve true si el nombre dado está activo en la tabla `header`.
     * Ejemplos válidos: 'Inicio', 'Nosotros', 'Programas de estudio',
     * 'Admisión y matrícula', 'Transparencia', 'Trámite', 'Servicios',
     * 'Otras páginas', 'Contáctanos'.
     */
    function header_on(string $name): bool
    {
        $key = Str::slug($name); // normaliza acentos/espacios

        $map = Cache::remember('header_vis_map', now()->addMinutes(30), function () {
            return Header::select('nombre', 'is_active')->get()
                ->mapWithKeys(fn ($r) => [ Str::slug($r->nombre) => (bool) $r->is_active ])
                ->toArray();
        });

        return (bool) ($map[$key] ?? false);
    }
}

if (! function_exists('submodulos_activos_de')) {
    /**
     * Devuelve colección de submódulos ACTIVOS de un módulo (por nombre o id).
     * $header puede ser el nombre exacto en BD ("Nosotros") o el id del módulo.
     */
    function submodulos_activos_de($header)
    {
        $cacheKey = 'header_subs_vis_map';

        $map = Cache::remember($cacheKey, now()->addMinutes(30), function () {
            // Estructura: [ header_id => [ ['id'=>..,'nombre'=>..], ... ] ]
            return Submodulo::query()
                ->where('is_active', true)
                ->orderBy('header_id')
                ->orderBy('id')
                ->get(['id','header_id','nombre'])
                ->groupBy('header_id')
                ->map(function ($items) {
                    return $items->map(fn($i) => ['id'=>$i->id,'nombre'=>$i->nombre])->values()->all();
                })
                ->toArray();
        });

        // Resolver header_id desde nombre si pasaron el nombre
        $headerId = is_numeric($header)
            ? (int) $header
            : (\App\Models\Header::where('nombre', $header)->value('id') ?? null);

        return collect($map[$headerId] ?? []);
    }
}

if (! function_exists('sub_on')) {
    /**
     * True si un submódulo está activo (por nombre y módulo).
     */
    function sub_on(string $headerName, string $subName): bool
    {
        $activos = submodulos_activos_de($headerName)->pluck('nombre')->map('strtolower')->toArray();
        return in_array(strtolower($subName), $activos, true);
    }
}

if (! function_exists('sub_url')) {
    /**
     * Devuelve la URL para un submódulo, mapeando nombres a rutas reales.
     * Si no está mapeado, usa /{slug-del-submódulo} como fallback.
     */
    function sub_url(string $headerName, string $subName): string
    {
        $h = Str::slug($headerName);
        $s = Str::slug($subName);

        // Mapa de URLs "reales" según tu menú actual
        $map = [
            'nosotros' => [
                'presentacion-y-resena-historica' => '/presentacion',
                'mision-vision-y-valores'        => '/mision',
                'organizacion-institucional'     => '/organigrama',
                'plana-jerarquica'               => '/jerarquica',
                'plana-docente'                  => '/docente',
                'locales'                        => '/locales',
            ],
            'admision-y-matricula' => [
                'admision-2025' => '/admisión',   // tal como ya lo usas
                'matricula'     => '/matricula',
                'becas-y-creditos' => '/becas',
            ],
            'transparencia' => [
                'documentos-de-gestion'           => '/documentos',
                'inversiones-y-recursos-economicos'=> '/inversiones',
                'libro-de-reclamaciones'          => '/libro_reclamaciones',
                'licenciamiento'                  => '/licenciamiento',
                'estadistica'                     => '/estadisticas',
            ],
            'tramite' => [
                'tupa'                   => '/tupa',
                'procesos-academicos'    => '/assets/procesos.pdf', // PDF
                'servicios-de-tramite'   => '/servicios-tramites',
            ],
            'servicios' => [
                'biblioteca-virtual'                         => '#',
                'relacion-de-libros'                         => '#',
                'sistema-de-registro-de-informacion-academica'=> '#',
                'bolsa-laboral'                              => '#',
                'servicios-complementarios'                  => '/servicios_complementarios',
            ],
            'otras-paginas' => [
                'noticias' => '/noticias',
                'galeria'  => '/galeria',
            ],
        ];

        $raw = $map[$h][$s] ?? ('/'.Str::slug($subName));

        // Construimos URL absoluta correctamente (asset para /assets/*.pdf)
        if (Str::startsWith($raw, ['/assets'])) {
            return asset(ltrim($raw, '/'));
        }
        if (Str::startsWith($raw, ['http://', 'https://', '#'])) {
            return $raw;
        }
        return url($raw);
    }
}

if (! function_exists('sub_blank')) {
    /**
     * Indica si el enlace debe abrirse en nueva pestaña.
     * (p.ej. PDF de Procesos Académicos)
     */
    function sub_blank(string $headerName, string $subName): bool
    {
        return Str::slug($headerName) === 'tramite'
            && Str::slug($subName) === 'procesos-academicos';
    }
}