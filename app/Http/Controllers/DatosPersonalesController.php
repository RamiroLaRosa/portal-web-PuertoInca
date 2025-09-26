<?php

namespace App\Http\Controllers;

use App\Models\DatosPersonal;
use App\Models\PlanaDocente;
use App\Models\ProgramasEstudio;
use Illuminate\Http\Request;

class DatosPersonalesController extends Controller
{
    public function index()
    {
        $programas = ProgramasEstudio::activos()
            ->orderBy('nombre')
            ->get(['id', 'nombre']);

        return view('admin.nosotros.docente.personales.index', compact('programas'));
    }

    // Lista de docentes por programa (para el 2do combo)
    public function docentesPorPrograma(Request $request)
    {
        $programa = (int) $request->query('programa', 0);
        if ($programa <= 0) return response()->json(['data' => []]);

        $data = \App\Models\PlanaDocente::where('programa_estudio_id', $programa)
            ->orderBy('nombre')
            ->get(['id', 'nombre']);

        return response()->json(['data' => $data]);
    }

    // Lista datos_personales por docente
    public function list(Request $request)
    {
        $docente = (int) $request->query('docente', 0);
        if ($docente <= 0) return response()->json(['data' => []]);

        $rows = DatosPersonal::where('docente_id', $docente)
            ->orderBy('id')
            ->get(['id', 'nombres', 'apellidos', 'correo', 'telefono', 'is_active']);

        return response()->json(['data' => $rows]);
    }

    // Obtener un dato personal por id
    public function show($id)
    {
        $row = DatosPersonal::findOrFail($id);
        return response()->json($row);
    }

    // Crear
    public function store(Request $request)
    {
        $v = $request->validate([
            'docente_id' => 'required|exists:plana_docente,id',
            'nombres'    => 'required|string|max:150',
            'apellidos'  => 'required|string|max:150',
            'correo'     => 'required|email|max:255',
            'telefono'   => 'nullable|string|max:30',
        ]);

        $row = DatosPersonal::create([
            'docente_id' => $v['docente_id'],
            'nombres'    => $v['nombres'],
            'apellidos'  => $v['apellidos'],
            'correo'     => $v['correo'],
            'telefono'   => $v['telefono'] ?? '',
            'is_active'  => 1,
        ]);

        return response()->json(['ok' => true, 'row' => $row]);
    }

    // Actualizar
    public function update(Request $request, $id)
    {
        $row = DatosPersonal::findOrFail($id);

        $v = $request->validate([
            'docente_id' => 'required|exists:plana_docente,id',
            'nombres'    => 'required|string|max:150',
            'apellidos'  => 'required|string|max:150',
            'correo'     => 'required|email|max:255',
            'telefono'   => 'nullable|string|max:30',
        ]);

        $row->update($v);

        return response()->json(['ok' => true, 'row' => $row]);
    }

    // Eliminar
    public function destroy($id)
    {
        $row = DatosPersonal::findOrFail($id);
        $row->delete();
        return response()->json(['ok' => true]);
    }
}
