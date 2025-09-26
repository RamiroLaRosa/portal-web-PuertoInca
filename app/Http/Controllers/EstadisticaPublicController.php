<?php
// app/Http/Controllers/EstadisticaPublicController.php

namespace App\Http\Controllers;

use App\Models\Estadistica;
use App\Models\TemaEstadistico;
use App\Models\AnioEstadistico;
use App\Models\ProgramasEstudio;
use Illuminate\Support\Str;

class EstadisticaPublicController extends Controller
{
    public function index()
    {
        // Catálogos ordenados
        $temas     = TemaEstadistico::where('is_active', 1)->orderBy('id')->get(['id','tema']);
        $aniosCol  = AnioEstadistico::where('is_active', 1)->orderBy('anio')->get(['id','anio']);
        $progsCol  = ProgramasEstudio::where('is_active', 1)->orderBy('nombre')->get(['id','nombre']);

        // Listas auxiliares
        $yearIds   = $aniosCol->pluck('id')->all();                // [1,2,3,...]
        $years     = $aniosCol->pluck('anio')->all();              // [2020,2021,...]
        $programs  = $progsCol->pluck('nombre','id')->all();       // [id => "Ingeniería", ...]

        // Para iconos bonitos en cada sección
        $iconByTema = [
            'ingresantes' => 'user-plus',
            'egresados'   => 'graduation-cap',
            'titulados'   => 'award',
            // si algún día agregas más, mapea aquí
        ];

        $sections = [];

        foreach ($temas as $t) {
            // slug para ancla/navegación
            $slug = Str::slug($t->tema, '-'); // p.ej. "INGRESANTES" -> "ingresantes"

            // Inicializa matriz programa × año con 0
            $grid = [];
            foreach ($programs as $pid => $pname) {
                $grid[$pid] = array_fill_keys($yearIds, 0);
            }

            // Trae registros del tema y completa matriz
            $regs = Estadistica::where('tema_estadistico_id', $t->id)
                ->where('is_active', 1)
                ->get(['programa_estudio_id','anio_estadistico_id','cantidad']);

            foreach ($regs as $r) {
                if (isset($grid[$r->programa_estudio_id]) && isset($grid[$r->anio_estadistico_id])) {
                    $grid[$r->programa_estudio_id][$r->anio_estadistico_id] = (int) $r->cantidad;
                }
            }

            // Datasets para Chart.js (uno por programa)
            $datasets = [];
            foreach ($programs as $pid => $pname) {
                $row = $grid[$pid];
                // valores en el mismo orden de $yearIds
                $datasets[] = [
                    'label' => $pname,
                    'data'  => array_values($row),
                ];
            }

            // icono por tema (fallback si no está mapeado)
            $icon = $iconByTema[$slug] ?? 'chart-bar';

            $sections[] = [
                'id'       => $slug,
                'titulo'   => $t->tema,
                'icon'     => $icon,
                'grid'     => $grid,      // [programId => [yearId => cantidad]]
                'datasets' => $datasets,  // para Chart.js
            ];
        }

        return view('transparencia.estadistica', [
            'years'     => $years,       // ej. [2020,2021,2022,2023,2024,2025]
            'yearIds'   => $yearIds,     // ej. [1,2,3,4,5,6]
            'programs'  => $programs,    // ej. [1=>"Ing. Sistemas", 2=>"Admin", ...]
            'sections'  => $sections,    // secciones ya armadas
        ]);
    }
}
