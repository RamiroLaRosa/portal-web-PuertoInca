<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ProgramasEstudio;
use App\Models\PlanaDocente;
use App\Models\DatoAcademico;
use App\Models\DatoLaboral;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DocentePublicController extends Controller
{
    public function index()
    {
        // Programas activos con sus docentes activos (ordenados)
        $programas = ProgramasEstudio::activos()
            ->with(['docentes' => function ($q) {
                $q->where('is_active', 1)->orderBy('id');
            }])
            ->orderBy('id')
            ->get();

        return view('nosotros.docente', compact('programas'));
    }

    public function personal($id)
    {
        $docente = PlanaDocente::where('id', $id)
            ->where('is_active', 1)
            ->with(['datosPersonal' => function ($q) {
                $q->where('is_active', 1);
            }])
            ->firstOrFail();

        $foto = $docente->foto ? asset(ltrim($docente->foto, '/')) : asset('images/no-photo.jpg');

        return response()->json([
            'ok'      => true,
            'docente' => [
                'id'     => $docente->id,
                'nombre' => $docente->nombre,
                'cargo'  => $docente->cargo,
                'correo' => $docente->correo,
                'foto'   => $foto,
            ],
            'personal' => $docente->datosPersonal
                ? [
                    'nombres'   => $docente->datosPersonal->nombres,
                    'apellidos' => $docente->datosPersonal->apellidos,
                    'correo'    => $docente->datosPersonal->correo ?: $docente->correo,
                    'cargo'     => $docente->cargo,   // <-- en lugar de teléfono
                ]
                : [
                    'nombres'   => null,
                    'apellidos' => null,
                    'correo'    => $docente->correo,
                    'cargo'     => $docente->cargo,
                ],
        ]);
    }

    public function datosAcademicos($id)
    {
        $docente = PlanaDocente::findOrFail($id);

        $rows = DatoAcademico::where('docente_id', $id)
            ->where('is_active', 1)
            ->orderBy('id')
            ->get([
                'grado',
                'situacion_academica',
                'especialidad',
                'institucion_educativa',
                'fecha_emision',
                'registro',
            ]);

        return response()->json([
            'ok'      => true,
            'docente' => [
                'id'     => $docente->id,
                'nombre' => $docente->nombre,
                'cargo'  => $docente->cargo,
            ],
            'data'    => $rows,
        ]);
    }

    public function laborales($id)
    {
        $doc = PlanaDocente::findOrFail($id);

        $rows = DatoLaboral::where('docente_id', $id)
            ->where('is_active', 1)
            ->orderBy('inicio_labor', 'desc')
            ->get(['institucion', 'cargo', 'experiencia', 'inicio_labor', 'termino_labor', 'tiempo_cargo']);

        return response()->json([
            'ok' => true,
            'docente' => [
                'id'     => $doc->id,
                'nombre' => $doc->nombre,
                'cargo'  => $doc->cargo,
                'correo' => $doc->correo,
                'foto'   => $this->assetFromDb($doc->foto),
            ],
            'data' => $rows,
        ]);
    }

    private function assetFromDb(?string $path): string
    {
        if (!$path) return asset('images/no-photo.jpg');
        $p = ltrim($path, './');        // normaliza "./images/..." -> "images/..."
        return Str::startsWith($p, ['http://', 'https://']) ? $p : asset($p);
    }

    public function unidades($id)
    {
        // Cursos del docente agrupados por módulo y semestre
        $rows = DB::table('unidades_didacticas as ud')
            ->join('programa_cursos_malla as c', 'c.id', '=', 'ud.programa_curso_id')
            ->join('programa_semestres_malla as s', 's.id', '=', 'c.semestre_malla_id')
            ->join('programa_modulos_malla as m', 'm.id', '=', 's.modulo_malla_id')
            ->where('ud.plana_docente_id', $id)
            ->orderBy('m.id')->orderBy('s.id')->orderBy('c.id')
            ->get([
                'm.id as modulo_id',
                'm.nombre as modulo',
                's.id as semestre_id',
                's.nombre as semestre',
                'c.id as curso_id',
                'c.nombre as curso',
                'c.creditos',
                'c.horas'
            ]);

        // Docente (para el título del modal si lo necesitas)
        $doc = DB::table('plana_docente')->where('id', $id)->first(['id', 'nombre', 'cargo']);

        // Agrupar en PHP
        $mods = [];
        foreach ($rows as $r) {
            $mods[$r->modulo_id]['nombre'] = $r->modulo;
            $mods[$r->modulo_id]['semestres'][$r->semestre_id]['nombre'] = $r->semestre;
            $mods[$r->modulo_id]['semestres'][$r->semestre_id]['cursos'][] = [
                'id'       => $r->curso_id,
                'nombre'   => $r->curso,
                'creditos' => (int)$r->creditos,
                'horas'    => (int)$r->horas,
            ];
        }

        $grupos = [];
        foreach ($mods as $mod) {
            $semestres = [];
            foreach ($mod['semestres'] ?? [] as $sem) {
                $semestres[] = [
                    'semestre' => $sem['nombre'],
                    'cursos'   => $sem['cursos'] ?? [],
                ];
            }
            $grupos[] = [
                'modulo'    => $mod['nombre'],
                'semestres' => $semestres,
            ];
        }

        return response()->json([
            'ok'      => true,
            'docente' => $doc ? ['id' => $doc->id, 'nombre' => $doc->nombre, 'cargo' => $doc->cargo] : null,
            'grupos'  => $grupos,
        ]);
    }
}
