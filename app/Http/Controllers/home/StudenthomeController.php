<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Models\Subjectenrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class StudenthomeController extends Controller
{

    public function homeStudentData()
    {

        $userId = Auth::User()->id;

        $result = SubjectEnrollment::select(
            'cursos.codcurso',
            'cursos.nombre AS curso',
            'cursos.tipo',
            'cursos.creditos',
            'periodos.numero AS periodo',
            DB::raw("CONCAT(semestres.anho,'-',semestres.numero) AS semestre"),
            'matriculas_asignaturas.nota'
        )
            ->join('asignaturas', 'asignaturas.id', '=', 'matriculas_asignaturas.subject_id')
            ->join('cursos', 'cursos.id', '=', 'asignaturas.course_id')
            ->join('periodos', 'periodos.id', '=', 'cursos.period_id')
            ->join('semestres', 'semestres.id', '=', 'asignaturas.semester_id')
            ->join('estudiantes', 'estudiantes.id', '=', 'matriculas_asignaturas.student_id')
            ->where('estudiantes.user_id', '=', $userId)
            ->whereRaw('semestres.anho = YEAR(NOW())')
            ->orderByRaw('semestre DESC')
            ->get();

        if ($result->count() > 0) {
            return response()->json([
                "status" => true,
                "mensaje" => 'Éxito, datos encontrados',
                "data" => $result,
            ]);
        } else {
            return response()->json([
                "status" => false,
                "mensaje" => 'Error, datos null',
                "data" => [],
            ]);
        }
    }



    public function list_history_cursos(Request $request)
    {

        if ($request->ajax()) {

            $user = Auth::user();
            $studentdata = $user->students;
            $idstudent = $studentdata[0]->id;

            $data = DB::table('matriculas_asignaturas AS ma')
                ->selectRaw('
                    se.id AS idsemester,
                    CONCAT(se.anho, "-", se.numero) AS semestre,
                    pl.nombre AS plan,
                    pe.numero AS periodo,
                    c.codcurso AS codcurso,
                    c.nombre AS curso,  
                    a.seccion,
                    a.turno,
                    CONCAT(u.nombres, " ", u.apellido_pa, " ", u.apellido_ma) AS docente,
                    tn.id AS idtiponota,
                    tn.nombre AS tipo_nota,
                    tn.porcentaje AS porcentaje,
                    COALESCE(ROUND(SUM(ep.nota * porcentaje) / COUNT(ep.id), 1), 0) AS promedio_notas
                ')
                ->leftJoin('asignaturas AS a', 'a.id', '=', 'ma.subject_id')
                ->join('cursos AS c', 'c.id', '=', 'a.course_id')
                ->join('periodos AS pe', 'pe.id', '=', 'c.period_id')
                ->join('planes AS pl', 'pl.id', '=', 'pe.plan_id')
                ->join('programas AS pr', 'pr.id', '=', 'pl.program_id')
                ->join('semestres AS se', 'se.id', '=', 'a.semester_id')
                ->leftJoin('docentes AS d', 'd.id', '=', 'a.teacher_id')
                ->leftJoin('usuarios AS u', 'u.id', '=', 'd.user_id')
                ->leftJoin('calendario_programacion AS cp', 'cp.subject_id', '=', 'a.id')
                ->leftJoin('tipos_notas AS tn', 'tn.id', '=', 'cp.gradetype_id')
                ->leftJoin('asignar_programacion AS ap', 'ap.schedulingcalendar_id', '=', 'cp.id')
                ->leftJoin('evaluando_programacion AS ep', function ($join) {
                    $join->on('ep.assignedprogramming_id', '=', 'ap.id')
                        ->on('ep.student_id', '=', 'ma.student_id');
                })
                ->where('ma.student_id', '=', $idstudent)
                ->groupBy('idsemester', 'semestre', 'plan', 'periodo', 'curso', 'codcurso', 'seccion', 'turno', 'docente', 'idtiponota', 'tipo_nota', 'porcentaje')
                ->orderByDesc('idsemester');

            $promedios = DB::table(DB::raw('(' . $data->toSql() . ') AS subconsulta'))
                ->mergeBindings($data)
                ->groupBy('idsemester', 'semestre', 'plan', 'periodo', 'curso', 'codcurso', 'seccion', 'turno', 'docente')
                ->selectRaw('
                    idsemester,
                    semestre,
                    plan,
                    periodo,
                    codcurso,
                    curso,
                    seccion,
                    turno,
                    docente,
                    ROUND(SUM(promedio_notas), 1) AS promedio_final
                ')
                ->orderByDesc('idsemester')
                ->get();

            // datatable
            return DataTables::of($promedios)
                ->addIndexColumn()
                ->make(true);
        }
        return response()->json(["status" => false, "mensaje" => 'Error: no se pueden cargar los estudiantes']);
    }
    

        // CONSULTA ANTIGUA
        // $data = DB::table('matriculas_asignaturas')
        //     ->select(
        //         'semestres.anho AS anho',
        //         'semestres.numero AS numero',
        //         DB::raw("CONCAT(semestres.anho,'-',semestres.numero) AS semestre"),
        //         'estudiantes.user_id',
        //         'cursos.codcurso',
        //         'cursos.nombre as curso',
        //         DB::raw("CONCAT(usuarios.nombres,' ', usuarios.apellido_pa,' ', usuarios.apellido_ma) AS docente"),
        //         'cursos.tipo',
        //         'asignaturas.seccion',
        //         'asignaturas.turno',
        //         'cursos.horas',
        //         'cursos.creditos',
        //         'periodos.numero as periodo',
        //         DB::raw("IF(matriculas_asignaturas.nota IS NULL, 0, matriculas_asignaturas.nota) AS notalumno")
        //     )
        //     ->join('asignaturas', 'asignaturas.id', '=', 'matriculas_asignaturas.subject_id')
        //     ->leftJoin('docentes', 'asignaturas.teacher_id', '=', 'docentes.id')
        //     ->join('cursos', 'cursos.id', '=', 'asignaturas.course_id')
        //     ->join('periodos', 'periodos.id', '=', 'cursos.period_id')
        //     ->join('semestres', 'semestres.id', '=', 'asignaturas.semester_id')
        //     ->join('estudiantes', 'estudiantes.id', '=', 'matriculas_asignaturas.student_id')
        //     ->leftJoin('usuarios', 'usuarios.id', '=', 'docentes.user_id')
        //     ->where('estudiantes.user_id', '=', $userId)
        //     ->orderBy('curso', 'asc')
        //     ->orderByDesc('anho')
        //     ->orderByDesc('numero')
        //     ->get();
}
