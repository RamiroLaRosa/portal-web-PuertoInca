<?php

namespace App\Http\Controllers;

use App\Models\DatoAcademico;
use App\Models\PlanaDocente;
use App\Models\ProgramasEstudio;       // si tu modelo se llama ProgramasEstudio, usa: use App\Models\ProgramasEstudio as ProgramaEstudio;
use Illuminate\Http\Request;

class DatosAcademicosController extends Controller
{
    public function index()
    {
        $programas = ProgramasEstudio::orderBy('nombre')->get(['id','nombre']);
        return view('admin.nosotros.docente.academicos.index', compact('programas'));
    }

    // GET /docentes?programa=ID
    public function docentesPorPrograma(Request $request)
    {
        $programa = (int) $request->query('programa', 0);
        if ($programa <= 0) return response()->json(['data' => []]);

        $data = PlanaDocente::where('programa_estudio_id', $programa)
            ->orderBy('nombre')
            ->get(['id','nombre']);

        return response()->json(['data' => $data]);
    }

    // GET /list?docente=ID
    public function list(Request $request)
    {
        $docente = (int) $request->query('docente', 0);
        if ($docente <= 0) return response()->json(['data' => []]);

        $data = DatoAcademico::where('docente_id', $docente)
            ->orderBy('id')
            ->get([
                'id','docente_id','grado','situacion_academica','especialidad',
                'institucion_educativa','fecha_emision','registro'
            ]);

        return response()->json(['data' => $data]);
    }

    public function show($id)
    {
        $d = DatoAcademico::findOrFail($id);
        return response()->json($d);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'docente_id'            => 'required|exists:plana_docente,id',
            'grado'                 => 'required|string|max:255',
            'situacion_academica'   => 'required|string|max:255',
            'especialidad'          => 'required|string|max:255',
            'institucion_educativa' => 'required|string|max:255',
            'fecha_emision'         => 'required|date',
            'registro'              => 'required|string|max:255',
        ]);

        $row = DatoAcademico::create($validated + ['is_active' => 1]);

        return response()->json(['ok' => true, 'row' => $row]);
    }

    public function update(Request $request, $id)
    {
        $row = DatoAcademico::findOrFail($id);

        $validated = $request->validate([
            'docente_id'            => 'required|exists:plana_docente,id',
            'grado'                 => 'required|string|max:255',
            'situacion_academica'   => 'required|string|max:255',
            'especialidad'          => 'required|string|max:255',
            'institucion_educativa' => 'required|string|max:255',
            'fecha_emision'         => 'required|date',
            'registro'              => 'required|string|max:255',
        ]);

        $row->update($validated);

        return response()->json(['ok' => true, 'row' => $row]);
    }

    public function destroy($id)
    {
        $row = DatoAcademico::findOrFail($id);
        $row->delete();
        return response()->json(['ok' => true]);
    }
}
