<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Subjectenrollment;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DocentehomeController extends Controller
{

    public function homeDocentesData() {

        $userId = Auth::User()->id;

        $result = Subject::select(
            'asignaturas.id as idsubject',
            'asignaturas.seccion',
            'asignaturas.turno',
            'asignaturas.tipo AS tipo_asignatura',
            'cursos.codcurso',
            'cursos.tipo AS tipo_curso',
            'cursos.nombre AS curso',
            DB::raw("CONCAT(semestres.anho,'-',semestres.numero) AS semestre"),
            'cursos.horas',
            'cursos.creditos',
            'periodos.numero AS periodo'
        )
        ->join('docentes', 'asignaturas.teacher_id', '=', 'docentes.id')
        ->join('cursos', 'cursos.id', '=', 'asignaturas.course_id')
        ->join('periodos', 'periodos.id', '=', 'cursos.period_id')
        ->join('semestres', 'semestres.id', '=', 'asignaturas.semester_id')
        ->where('docentes.user_id', '=', $userId  )
        ->whereRaw('semestres.anho = YEAR(NOW())') // Cuando se esta en el año actual
        // ->whereRaw('semestres.anho = 2024')
        ->get();

        if ($result->count() > 0) {
            return response()->json([
                "status" => true,
                "mensaje" => 'Éxito, datos encontrados',
                "data" =>$result
            ]);
        } else {
            return response()->json([
                "status" => false,
                "mensaje" => 'Error, datos null',
                "data" => []
            ]);
        }

    }


    public function list_students(Request $request)
    {
        $userId = Auth::User()->id;
        $idsubject = $request->input('idsubject');

        if ($request->ajax()) {
            // query
            $data = SubjectEnrollment::select(
                'estudiantes.user_id',
                'cursos.codcurso',
                'cursos.nombre AS curso',
                'cursos.tipo',
                'cursos.horas',
                'cursos.creditos',
                'periodos.numero AS periodo',
                DB::raw("CONCAT(semestres.anho,'-',semestres.numero) AS semestre"),
                'usuarios.nombres',
                'usuarios.apellido_pa',
                'usuarios.apellido_ma',
                'usuarios.nroidenti',
                'usuarios.correo',
                DB::raw("IF(matriculas_asignaturas.nota IS NULL, 0, matriculas_asignaturas.nota) AS notalumno")
            )
            ->join('asignaturas', 'asignaturas.id', '=', 'matriculas_asignaturas.subject_id')
            ->join('docentes', 'asignaturas.teacher_id', '=', 'docentes.id')
            ->join('cursos', 'cursos.id', '=', 'asignaturas.course_id')
            ->join('periodos', 'periodos.id', '=', 'cursos.period_id')
            ->join('semestres', 'semestres.id', '=', 'asignaturas.semester_id')
            ->join('estudiantes', 'estudiantes.id', '=', 'matriculas_asignaturas.student_id')
            ->join('usuarios', 'usuarios.id', '=', 'estudiantes.user_id')
            ->where('docentes.user_id', $userId)
            ->whereRaw('semestres.anho = YEAR(NOW())')
            ->where('asignaturas.id', $idsubject)
            ->get();

            // datatable
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
        return  response()->json(["status" => false, "mensaje" => 'Error: no se pueden cargar los estudiantes']);
    }


    public function homeDocentesDataTable(){

        $userId = Auth::User()->id;

        $result = SubjectEnrollment::select(
            'cursos.codcurso',
            'cursos.nombre AS curso',
            'cursos.tipo',
            'asignaturas.seccion',
            'asignaturas.turno',
            'cursos.horas',
            'cursos.creditos',
            'usuarios.nombres',
            'usuarios.apellido_pa',
            'usuarios.apellido_ma',
            'periodos.numero AS periodo',
            DB::raw("CONCAT(semestres.anho,'-',semestres.numero) AS semestre"),
            'matriculas_asignaturas.nota'
        )
        ->join('asignaturas', 'asignaturas.id', '=', 'matriculas_asignaturas.subject_id')
        ->join('docentes', 'docentes.id', '=', 'asignaturas.teacher_id')
        ->join('cursos', 'cursos.id', '=', 'asignaturas.course_id')
        ->join('periodos', 'periodos.id', '=', 'cursos.period_id')
        ->join('semestres', 'semestres.id', '=', 'asignaturas.semester_id')
        ->join('estudiantes', 'estudiantes.id', '=', 'matriculas_asignaturas.student_id')
        ->join('usuarios', 'usuarios.id', '=', 'estudiantes.user_id')
        ->where('docentes.user_id', '=', $userId )
        ->orderByRaw('semestre DESC')
        ->get();

        if ($result->count() > 0) {
            return response()->json([
                "status" => true,
                "mensaje" => 'Éxito, datos encontrados',
                "data" =>$result
            ]);
        } else {
            return response()->json([
                "status" => false,
                "mensaje" => 'Error, datos null',
                "data" => []
            ]);
        }
    }


    public function ajax_all_subjects(Request $request)
    {
        $userId = Auth::User()->id;

        if ($request->ajax()) {

            $data = DB::table('asignaturas')
            ->select(
                'asignaturas.id AS idsubject',
                'asignaturas.seccion AS seccion',
                'cursos.codcurso',
                'cursos.nombre AS curso',
                'cursos.tipo',
                'cursos.horas',
                'cursos.creditos',
                'periodos.numero AS periodo',
                DB::raw("CONCAT(semestres.anho,'-',semestres.numero) AS semestre")
            )
            ->join('docentes', 'asignaturas.teacher_id', '=', 'docentes.id')
            ->join('cursos', 'cursos.id', '=', 'asignaturas.course_id')
            ->join('periodos', 'periodos.id', '=', 'cursos.period_id')
            ->join('semestres', 'semestres.id', '=', 'asignaturas.semester_id')
            ->where('docentes.user_id', $userId)
            ->whereRaw('semestres.anho = YEAR(NOW())')
            ->orderBy('curso')
            ->get();

            return response()->json($data);

        }
        return  response()->json(["status" => false, "mensaje" => 'Error en request']);
    }


    public function ajax_all_subjectclasses(Request $request, $idsubject)
    {
        $userId = Auth::User()->id;

        if ($request->ajax()) {

            $data = DB::table('clases_asignaturas as ca')
                ->select(
                    'h.dia',
                    'h.horaini',
                    'h.horafin',
                    DB::raw("DATE_FORMAT(h.horaini, '%h:%i %p') as horaini2"), // Formato de 12 horas con AM/PM
                    DB::raw("DATE_FORMAT(h.horafin, '%h:%i %p') as horafin2"), // Formato de 12 horas con AM/PM
                    'ca.id as idclass',
                    'ca.nombre as clase',
                    'ca.fecha',
                    'ca.estado'
                )
                ->join('horarios as h', 'h.id', '=', 'ca.schedule_id')
                ->join('asignaturas as a', 'a.id', '=', 'h.subject_id')
                ->join('docentes as d', 'd.id', '=', 'a.teacher_id')
                ->join('semestres as s', 's.id', '=', 'a.semester_id')
                ->where('d.user_id', '=', $userId)
                ->where('a.id', '=', $idsubject)
                ->orderBy('fecha')
                ->get();

            return response()->json($data);

        }
        return  response()->json(["status" => false, "mensaje" => 'Error en request']);
    }

}
