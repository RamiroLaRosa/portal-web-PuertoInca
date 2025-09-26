<?php


namespace App\Http\Controllers;

use App\Models\ProgramasEstudio;
use App\Models\AdmisionResultado;
use App\Models\AdmisionModalidad;
use App\Models\AdmisionDocumento;
use App\Models\AdmisionCronograma;
use App\Models\AdmisionExonerado;
use App\Models\AdmisionVacante;
use App\Models\AdmisionPaso;

class AdmisionController extends Controller
{
    public function index()
    {
        $programas = ProgramasEstudio::activos()->orderBy('id')->get(['id', 'nombre']);

        $resultados = AdmisionResultado::activos()
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('programa_id');

        $TURNOS_DIURNO   = [1, 2];
        $TURNOS_NOCTURNO = [3];

        $filas = $programas->map(function ($p) use ($resultados, $TURNOS_DIURNO, $TURNOS_NOCTURNO) {
            $g = $resultados->get($p->id, collect());
            $diurno   = $g->first(fn($r) => in_array($r->turno_id, $TURNOS_DIURNO));
            $nocturno = $g->first(fn($r) => in_array($r->turno_id, $TURNOS_NOCTURNO));
            return compact('p', 'diurno', 'nocturno');
        });

        // 👇 NUEVO: modalidades activas
        $modalidades = AdmisionModalidad::where('is_active', 1)
            ->orderBy('id')
            ->get();

        $documentos = AdmisionDocumento::activos()
            ->with(['requisitos' => fn($q) => $q->activos()->orderBy('id')])
            ->orderBy('id')
            ->get();

        $cronograma = AdmisionCronograma::activos()->orderBy('id')->get();

        $exonerados = AdmisionExonerado::activos() // o ->where('is_active', 1)
            ->orderBy('id')
            ->get();

        $vacantes = AdmisionVacante::where('is_active', 1)
            ->with(['programa:id,nombre'])
            ->orderBy('programa_estudio_id')
            ->get();

        $pasos = AdmisionPaso::where('is_active', 1)
            ->orderBy('id')
            ->with([
                'procesos' => fn($q) => $q->where('is_active', 1)->orderBy('id')
            ])
            ->get();


        return view('admision.admision', compact('filas', 'modalidades', 'documentos', 'cronograma', 'exonerados', 'vacantes', 'pasos'));
    }
}
