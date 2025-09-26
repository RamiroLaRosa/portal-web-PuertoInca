<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnidadesDidacticasController extends Controller
{
    public function index()
    {
        // Programas de estudio
        $programas = DB::table('programas_estudios')
            ->whereNull('deleted_at')
            ->where('is_active', 1)
            ->orderBy('nombre')
            ->get(['id', 'nombre']);

        return view('admin.nosotros.docente.unidades.index', compact('programas'));
    }

    // === AJAX: Docentes por programa
    public function docentes(Request $r)
    {
        $pid = (int)$r->query('programa_id', 0);

        $rows = DB::table('plana_docente as d')
            ->whereNull('d.deleted_at')
            ->where('d.is_active', 1)
            ->when($pid, fn($q) => $q->where('d.programa_estudio_id', $pid))
            ->orderBy('d.nombre')
            ->get([
                'd.id',
                'd.nombre',
                'd.cargo',
                'd.correo',
                'd.foto',
            ]);

        $items = $rows->map(function ($x) {
            return [
                'id'     => $x->id,
                'nombre' => $x->nombre,
                'cargo'  => $x->cargo,
                'correo' => $x->correo,
                'foto'   => $x->foto,
            ];
        });

        return response()->json(['items' => $items]);
    }

    // === AJAX: Listado de unidades por docente
    public function listado(Request $r)
    {
        $pid = (int)$r->query('programa_id', 0);
        $did = (int)$r->query('docente_id', 0);

        $docente = DB::table('plana_docente')
            ->when($pid, fn($q) => $q->where('programa_estudio_id', $pid))
            ->where('id', $did)
            ->first(['id', 'nombre', 'cargo', 'correo', 'foto']);

        $items = DB::table('unidades_didacticas as ud')
            ->join('programa_cursos_malla as c', 'c.id', '=', 'ud.programa_curso_id')
            ->where('ud.plana_docente_id', $did)
            ->orderBy('ud.id')
            ->get([
                'ud.id',
                'c.nombre as curso',
                'c.creditos',
                'c.horas',
                'ud.is_active',
            ])->map(fn($x) => [
                'id'        => $x->id,
                'curso'     => $x->curso,
                'creditos'  => (int)$x->creditos,
                'horas'     => (int)$x->horas,
                'is_active' => (int)$x->is_active === 1,
            ]);

        return response()->json([
            'docente' => $docente,
            'items'   => $items,
        ]);
    }

    // === AJAX: Modulos del programa
    public function modulos(Request $r)
    {
        $pid = (int)$r->query('programa_id', 0);

        $rows = DB::table('programa_modulos_malla')
            ->where('programa_id', $pid)
            ->where('is_active', 1)
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get(['id', 'nombre']);

        return response()->json(['items' => $rows]);
    }

    // === AJAX: Semestres del módulo
    public function semestres(Request $r)
    {
        $mid = (int)$r->query('modulo_id', 0);

        $rows = DB::table('programa_semestres_malla')
            ->where('modulo_malla_id', $mid)
            ->where('is_active', 1)
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get(['id', 'nombre']);

        return response()->json(['items' => $rows]);
    }

    // === AJAX: Cursos del semestre
    public function cursos(Request $r)
    {
        $sid = (int)$r->query('semestre_id', 0);

        $rows = DB::table('programa_cursos_malla')
            ->where('semestre_malla_id', $sid)
            ->where('is_active', 1)
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get(['id', 'nombre', 'creditos', 'horas']);

        return response()->json(['items' => $rows]);
    }

    // === Crear unidad didáctica
    public function store(Request $r)
    {
        $data = $r->validate([
            'programa_id' => 'required|integer|min:1',
            'docente_id'  => 'required|integer|min:1',
            'curso_id'    => 'required|integer|min:1',
        ]);

        // Evitar duplicados docente-curso
        $exists = DB::table('unidades_didacticas')
            ->where('plana_docente_id', $data['docente_id'])
            ->where('programa_curso_id', $data['curso_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'ok'      => false,
                'message' => 'Este curso ya está asignado a este docente.'
            ], 422);
        }

        $id = DB::table('unidades_didacticas')->insertGetId([
            'plana_docente_id' => $data['docente_id'],
            'programa_curso_id' => $data['curso_id'],
            'is_active'        => 1,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        return response()->json(['ok' => true, 'id' => $id]);
    }

    // === Eliminar por ID
    public function destroy($id)
    {
        $deleted = DB::table('unidades_didacticas')->where('id', (int)$id)->delete();
        return response()->json(['ok' => (bool)$deleted]);
    }
}
