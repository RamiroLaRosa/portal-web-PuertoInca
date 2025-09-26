<?php

namespace App\Http\Controllers;

use App\Models\AdmisionResultado;
use App\Models\ProgramasEstudio;
use App\Models\Turno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdmisionResultadoController extends Controller
{
    public function index()
    {
        $items = AdmisionResultado::with(['programa', 'turno'])
            ->orderBy('id', 'asc')  
            ->get();

        $programas = ProgramasEstudio::activos()->orderBy('nombre')->get(['id', 'nombre']);
        $turnos    = Turno::activos()->orderBy('nombre')->get(['id', 'nombre']);

        return view('admin.admision_matricula.admision.resultados.index', compact('items', 'programas', 'turnos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'programa_id' => ['required', 'integer', 'exists:programas_estudios,id'],
            'turno_id'    => ['required', 'integer', 'exists:turno,id'],
            'documento'   => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        // 👇 Guardar en /public/assets
        $file = $request->file('documento');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('assets'), $filename);

        AdmisionResultado::create([
            'programa_id' => $data['programa_id'],
            'turno_id'    => $data['turno_id'],
            'documento'   => 'assets/' . $filename, // ruta relativa
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin-resultados.index')->with('success', 'Registro creado.');
    }

    public function update(Request $request, AdmisionResultado $admision_resultado)
    {
        $data = $request->validate([
            'programa_id' => ['required', 'integer', 'exists:programas_estudios,id'],
            'turno_id'    => ['required', 'integer', 'exists:turno,id'],
            'documento'   => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $admision_resultado->fill([
            'programa_id' => $data['programa_id'],
            'turno_id'    => $data['turno_id'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        // 👇 Guardar en /public/assets si hay nuevo archivo
        if ($request->hasFile('documento')) {
            $prev = public_path($admision_resultado->documento);
            if ($prev && file_exists($prev) && is_file($prev)) {
                @unlink($prev); // eliminar el anterior
            }

            $file = $request->file('documento');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets'), $filename);

            $admision_resultado->documento = 'assets/' . $filename;
        }

        $admision_resultado->save();

        return redirect()->route('admin-resultados.index')->with('success', 'Registro actualizado.');
    }

    public function destroy(AdmisionResultado $admision_resultado)
    {
        $admision_resultado->delete();
        return redirect()->route('admin-resultados.index')->with('success', 'Registro eliminado.');
    }
}
