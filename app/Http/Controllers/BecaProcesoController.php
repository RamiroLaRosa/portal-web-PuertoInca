<?php

namespace App\Http\Controllers;

use App\Models\BecaProceso;
use Illuminate\Http\Request;

class BecaProcesoController extends Controller
{
    public function index()
    {
        $items = BecaProceso::orderBy('nro_paso')->get();
        return view('admin.admision_matricula.beca.proceso.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nro_paso'    => ['required', 'integer', 'min:1', 'max:999'],
            'titulo'      => ['required', 'string', 'max:150'],
            'descripcion' => ['required', 'string', 'max:1000'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        BecaProceso::create([
            'nro_paso'    => $data['nro_paso'],
            'titulo'      => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('beca-pasos.index')->with('success', 'Proceso creado.');
    }

    public function update(Request $request, BecaProceso $paso)
    {
        $data = $request->validate([
            'nro_paso'    => ['required', 'integer', 'min:1', 'max:999'],
            'titulo'      => ['required', 'string', 'max:150'],
            'descripcion' => ['required', 'string', 'max:1000'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $paso->update([
            'nro_paso'    => $data['nro_paso'],
            'titulo'      => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('beca-pasos.index')->with('success', 'Proceso actualizado.');
    }

    public function destroy(BecaProceso $paso)
    {
        $paso->delete(); // Soft delete
        return redirect()->route('beca-pasos.index')->with('success', 'Proceso eliminado.');
    }
}
