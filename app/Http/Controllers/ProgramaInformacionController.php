<?php

namespace App\Http\Controllers;

use App\Models\ProgramasEstudio;
use App\Models\ProgramaInformacion;
use Illuminate\Http\Request;

class ProgramaInformacionController extends Controller
{
    public function index()
    {
        $programas = ProgramasEstudio::activos()->orderBy('nombre')->get(['id', 'nombre']);
        return view('admin.programas_estudios.informacion.index', compact('programas'));
    }

    public function list(Request $request)
    {
        $programaId = (int) $request->query('programa', 0);
        if ($programaId <= 0) {
            return response()->json(['data' => []]);
        }

        $data = ProgramaInformacion::where('programa_id', $programaId)
            ->orderBy('id')
            ->get(['id', 'duracion', 'modalidad', 'turno', 'horario', 'is_active']);

        return response()->json(['data' => $data]);
    }

    // Obtener un registro por ID (para precargar modal de edición)
    public function show($id)
    {
        $row = ProgramaInformacion::findOrFail($id, [
            'id',
            'programa_id',
            'duracion',
            'modalidad',
            'turno',
            'horario',
            'is_active'
        ]);
        return response()->json($row);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'programa_id' => ['required', 'integer', 'exists:programas_estudios,id'],
            'duracion'    => ['required', 'string', 'max:100'],
            'modalidad'   => ['required', 'string', 'max:100'],
            'turno'       => ['required', 'string', 'max:100'],
            'horario'     => ['required', 'string', 'max:150'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $row = new ProgramaInformacion([
            'programa_id' => (int) $data['programa_id'],
            'duracion'    => $data['duracion'],
            'modalidad'   => $data['modalidad'],
            'turno'       => $data['turno'],
            'horario'     => $data['horario'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        $row->save();

        return redirect()->route('informacion.index')->with('success', 'Registro creado.');
    }

    public function update(Request $request, $id)
    {
        $row = ProgramaInformacion::findOrFail($id);

        $data = $request->validate([
            'duracion'   => ['required', 'string', 'max:100'],
            'modalidad'  => ['required', 'string', 'max:100'],
            'turno'      => ['required', 'string', 'max:100'],
            'horario'    => ['required', 'string', 'max:150'],
            'is_active'  => ['nullable', 'boolean'],
        ]);

        $row->fill([
            'duracion'  => $data['duracion'],
            'modalidad' => $data['modalidad'],
            'turno'     => $data['turno'],
            'horario'   => $data['horario'],
            'is_active' => $request->boolean('is_active'),
        ]);

        $row->save();

        return redirect()->route('informacion.index')->with('success', 'Registro actualizado.');
    }

    public function destroy($id)
    {
        $row = ProgramaInformacion::findOrFail($id);
        $row->delete();

        return redirect()->route('informacion.index')->with('success', 'Registro eliminado.');
    }
}
