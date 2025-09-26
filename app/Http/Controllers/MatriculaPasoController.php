<?php

namespace App\Http\Controllers;

use App\Models\MatriculaPaso;
use Illuminate\Http\Request;

class MatriculaPasoController extends Controller
{
    public function index()
    {
        $items = MatriculaPaso::orderBy('numero_paso','asc')->get();
        return view('admin.admision_matricula.matricula.proceso.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'numero_paso' => ['required','integer','min:1','max:9999'],
            'titulo'      => ['required','string','max:150'],
            'descripcion' => ['required','string','max:1000'],
            'is_active'   => ['nullable','boolean'],
        ]);

        MatriculaPaso::create([
            'numero_paso' => $data['numero_paso'],
            'titulo'      => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('matri-pasos.index')->with('success','Registro creado.');
    }

    public function update(Request $request, MatriculaPaso $paso)
    {
        $data = $request->validate([
            'numero_paso' => ['required','integer','min:1','max:9999'],
            'titulo'      => ['required','string','max:150'],
            'descripcion' => ['required','string','max:1000'],
            'is_active'   => ['nullable','boolean'],
        ]);

        $paso->update([
            'numero_paso' => $data['numero_paso'],
            'titulo'      => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('matri-pasos.index')->with('success','Registro actualizado.');
    }

    public function destroy(MatriculaPaso $paso)
    {
        $paso->delete(); // SoftDelete
        return redirect()->route('matri-pasos.index')->with('success','Registro eliminado.');
    }
}
