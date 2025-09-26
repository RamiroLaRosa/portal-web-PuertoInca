<?php

namespace App\Http\Controllers;

use App\Models\AdmisionProceso;
use App\Models\AdmisionPaso;
use Illuminate\Http\Request;

class AdmisionProcesoController extends Controller
{
    public function index()
    {
        $items = AdmisionProceso::with('paso')
            ->orderBy('id', 'asc')
            ->get();

        // Combo de pasos (solo activos)
        $pasos = AdmisionPaso::where('is_active', 1)
            ->orderBy('id', 'asc')
            ->get(['id','paso','icono']);

        return view('admin.admision_matricula.admision.proceso.index', compact('items','pasos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'admision_paso_id' => ['required','integer','exists:admision_pasos,id'],
            'descripcion'      => ['required','string','max:5000'],
            'is_active'        => ['nullable','boolean'],
        ]);

        AdmisionProceso::create([
            'admision_paso_id' => $data['admision_paso_id'],
            'descripcion'      => $data['descripcion'],
            'is_active'        => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin-proceso.index')->with('success','Registro creado.');
    }

    public function update(Request $request, AdmisionProceso $proceso)
    {
        $data = $request->validate([
            'admision_paso_id' => ['required','integer','exists:admision_pasos,id'],
            'descripcion'      => ['required','string','max:5000'],
            'is_active'        => ['nullable','boolean'],
        ]);

        $proceso->update([
            'admision_paso_id' => $data['admision_paso_id'],
            'descripcion'      => $data['descripcion'],
            'is_active'        => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin-proceso.index')->with('success','Registro actualizado.');
    }

    public function destroy(AdmisionProceso $proceso)
    {
        $proceso->delete(); // usa SoftDelete; cambia a forceDelete() si quieres borrado duro
        return redirect()->route('admin-proceso.index')->with('success','Registro eliminado.');
    }
}
