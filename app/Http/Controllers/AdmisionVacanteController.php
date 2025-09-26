<?php

namespace App\Http\Controllers;

use App\Models\AdmisionVacante;
use App\Models\ProgramasEstudio;
use Illuminate\Http\Request;

class AdmisionVacanteController extends Controller
{
    public function index()
    {
        $items = AdmisionVacante::with('programa')
            ->orderBy('id', 'asc')
            ->get();

        // Para el combo de programas (solo activos)
        $programas = ProgramasEstudio::where('is_active', 1)
            ->orderBy('nombre', 'asc')
            ->get(['id', 'nombre']);

        return view('admin.admision_matricula.admision.vacantes.index', compact('items', 'programas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'programa_estudio_id' => ['required', 'integer', 'exists:programas_estudios,id'],
            'vacantes'            => ['required', 'integer', 'min:0', 'max:100000'],
            'is_active'           => ['nullable', 'boolean'],
        ]);

        AdmisionVacante::create([
            'programa_estudio_id' => $data['programa_estudio_id'],
            'vacantes'            => $data['vacantes'],
            'is_active'           => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin-vacantes.index')->with('success', 'Registro creado.');
    }

    public function update(Request $request, AdmisionVacante $vacante)
    {
        $data = $request->validate([
            'programa_estudio_id' => ['required', 'integer', 'exists:programas_estudios,id'],
            'vacantes'            => ['required', 'integer', 'min:0', 'max:100000'],
            'is_active'           => ['nullable', 'boolean'],
        ]);

        $vacante->update([
            'programa_estudio_id' => $data['programa_estudio_id'],
            'vacantes'            => $data['vacantes'],
            'is_active'           => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin-vacantes.index')->with('success', 'Registro actualizado.');
    }

    public function destroy(AdmisionVacante $vacante)
    {
        $vacante->delete();
        return redirect()->route('admin-vacantes.index')->with('success', 'Registro eliminado.');
    }
}
