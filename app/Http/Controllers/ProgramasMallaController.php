<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramasEstudio;
use App\Models\ProgramaModuloMalla;
use App\Models\ProgramaSemestreMalla;
use App\Models\ProgramaCursoMalla;

class ProgramasMallaController extends Controller
{
    // GET /{programa}/malla
    public function index(int $programaId)
    {
        $programa = ProgramasEstudio::activos()->findOrFail($programaId);

        $modulos = ProgramaModuloMalla::where('programa_id', $programaId)
            ->orderBy('id')
            ->with(['semestres' => function ($q) {
                $q->orderBy('id')->with(['cursos' => fn($qq) => $qq->orderBy('id')]);
            }])
            ->get();

        return response()->json([
            'ok'      => true,
            'programa' => ['id' => $programa->id, 'nombre' => $programa->nombre],
            'items'   => $modulos,
        ]);
    }

    /* ------------------------ MÓDULO ------------------------ */
    public function storeModulo(Request $req, int $programaId)
    {
        $data = $req->validate(['nombre' => 'required|string|max:150']);
        $row = ProgramaModuloMalla::create([
            'programa_id' => $programaId,
            'nombre'      => $data['nombre'],
            'is_active'   => 1,
        ]);
        return response()->json(['ok' => true, 'modulo' => $row]);
    }

    public function updateModulo(Request $req, int $programaId, int $moduloId)
    {
        $data = $req->validate(['nombre' => 'required|string|max:150']);
        $row = ProgramaModuloMalla::where('programa_id', $programaId)->findOrFail($moduloId);
        $row->update(['nombre' => $data['nombre']]);
        return response()->json(['ok' => true]);
    }

    public function destroyModulo(int $programaId, int $moduloId)
    {
        $row = ProgramaModuloMalla::where('programa_id', $programaId)->findOrFail($moduloId);
        $row->delete(); // Si prefieres "is_active = 0" cámbialo aquí
        return response()->json(['ok' => true]);
    }

    /* ------------------------ SEMESTRE ------------------------ */
    public function storeSemestre(Request $req, int $programaId)
    {
        $data = $req->validate([
            'modulo_malla_id' => 'required|integer',
            'nombre'          => 'required|string|max:150',
        ]);

        // verificación de pertenencia
        $mod = ProgramaModuloMalla::where('programa_id', $programaId)->findOrFail($data['modulo_malla_id']);

        $row = ProgramaSemestreMalla::create([
            'modulo_malla_id' => $mod->id,
            'nombre'          => $data['nombre'],
            'is_active'       => 1,
        ]);
        return response()->json(['ok' => true, 'semestre' => $row]);
    }

    public function updateSemestre(Request $req, int $programaId, int $semestreId)
    {
        $data = $req->validate(['nombre' => 'required|string|max:150']);
        $row = ProgramaSemestreMalla::findOrFail($semestreId);
        // opcional: verificar que el semestre pertenezca al programa
        if ($row->modulo->programa_id != $programaId) abort(404);
        $row->update(['nombre' => $data['nombre']]);
        return response()->json(['ok' => true]);
    }

    public function destroySemestre(int $programaId, int $semestreId)
    {
        $row = ProgramaSemestreMalla::findOrFail($semestreId);
        if ($row->modulo->programa_id != $programaId) abort(404);
        $row->delete();
        return response()->json(['ok' => true]);
    }

    /* ------------------------ CURSO ------------------------ */
    public function storeCurso(Request $req, int $programaId)
    {
        $data = $req->validate([
            'semestre_malla_id' => 'required|integer',
            'nombre'            => 'required|string|max:200',
            'creditos'          => 'required|integer|min:0',
            'horas'             => 'required|integer|min:0',
        ]);

        $sem = ProgramaSemestreMalla::findOrFail($data['semestre_malla_id']);
        if ($sem->modulo->programa_id != $programaId) abort(404);

        $row = ProgramaCursoMalla::create([
            'semestre_malla_id' => $sem->id,
            'nombre'            => $data['nombre'],
            'creditos'          => $data['creditos'],
            'horas'             => $data['horas'],
            'is_active'         => 1,
        ]);

        return response()->json(['ok' => true, 'curso' => $row]);
    }

    public function updateCurso(Request $req, int $programaId, int $cursoId)
    {
        $data = $req->validate([
            'nombre'   => 'required|string|max:200',
            'creditos' => 'required|integer|min:0',
            'horas'    => 'required|integer|min:0',
        ]);

        $row = ProgramaCursoMalla::findOrFail($cursoId);
        if ($row->semestre->modulo->programa_id != $programaId) abort(404);

        $row->update($data);
        return response()->json(['ok' => true]);
    }

    public function destroyCurso(int $programaId, int $cursoId)
    {
        $row = ProgramaCursoMalla::findOrFail($cursoId);
        if ($row->semestre->modulo->programa_id != $programaId) abort(404);
        $row->delete();
        return response()->json(['ok' => true]);
    }
}
