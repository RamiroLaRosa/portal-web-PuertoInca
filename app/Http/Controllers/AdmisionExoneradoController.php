<?php

namespace App\Http\Controllers;

use App\Models\AdmisionExonerado;
use Illuminate\Http\Request;

class AdmisionExoneradoController extends Controller
{
    public function index()
    {
        $items = AdmisionExonerado::orderBy('id', 'asc')->get();

        // Opciones para el combo de iconos
        $iconOptions = [
            ['label' => 'Trofeo',        'value' => 'fa-solid fa-trophy'],
            ['label' => 'Medalla',       'value' => 'fa-solid fa-medal'],
            ['label' => 'Estrella',      'value' => 'fa-solid fa-star'],
            ['label' => 'Laurel',        'value' => 'fa-solid fa-crown'],
            ['label' => 'Libro abierto', 'value' => 'fa-solid fa-book-open'],
            ['label' => 'Graduación',    'value' => 'fa-solid fa-graduation-cap'],
            ['label' => 'Certificado',   'value' => 'fa-solid fa-award'],
            ['label' => 'Música',        'value' => 'fa-solid fa-music'],
            ['label' => 'Usuario',       'value' => 'fa-solid fa-user'],
            ['label' => 'Check',         'value' => 'fa-solid fa-check'],
        ];

        return view('admin.admision_matricula.admision.exonerados.index', compact('items','iconOptions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'      => ['required','string','max:200'],
            'descripcion' => ['required','string'],
            'icono'       => ['required','string','max:100'],
            'is_active'   => ['nullable','boolean'],
        ]);

        AdmisionExonerado::create([
            'titulo'      => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'icono'       => $data['icono'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin-exonerados.index')->with('success','Registro creado.');
    }

    public function update(Request $request, AdmisionExonerado $exonerado)
    {
        $data = $request->validate([
            'titulo'      => ['required','string','max:200'],
            'descripcion' => ['required','string'],
            'icono'       => ['required','string','max:100'],
            'is_active'   => ['nullable','boolean'],
        ]);

        $exonerado->update([
            'titulo'      => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'icono'       => $data['icono'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin-exonerados.index')->with('success','Registro actualizado.');
    }

    public function destroy(AdmisionExonerado $exonerado)
    {
        $exonerado->delete(); // usa ->forceDelete() si quieres hard delete
        return redirect()->route('admin-exonerados.index')->with('success','Registro eliminado.');
    }
}
