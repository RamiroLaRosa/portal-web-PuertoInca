<?php

// app/Http/Controllers/ValoresController.php
namespace App\Http\Controllers;

use App\Models\Valor;
use Illuminate\Http\Request;

class ValoresController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => ['required','string','max:120'],
            'descripcion' => ['required','string'],
            'icono'       => ['required','string','max:80'], // ej: fa-solid fa-star
            'is_active'   => ['nullable','boolean'],
        ]);

        Valor::create([
            'nombre'      => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'icono'       => $data['icono'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('mv.index')->with('success','Valor creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $valor = Valor::findOrFail($id);

        $data = $request->validate([
            'nombre'      => ['required','string','max:120'],
            'descripcion' => ['required','string'],
            'icono'       => ['required','string','max:80'],
            'is_active'   => ['nullable','boolean'],
        ]);

        $valor->update([
            'nombre'      => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'icono'       => $data['icono'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('mv.index')->with('success','Valor actualizado correctamente.');
    }

    public function destroy($id)
    {
        Valor::findOrFail($id)->delete(); // Soft delete
        return redirect()->route('mv.index')->with('success','Valor eliminado correctamente.');
    }
}
