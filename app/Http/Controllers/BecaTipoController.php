<?php

namespace App\Http\Controllers;

use App\Models\BecaTipo;
use Illuminate\Http\Request;

class BecaTipoController extends Controller
{
    /** Opciones para el combobox de iconos (label => value) */
    private array $iconOptions = [
        'Trofeo (excelencia)'       => 'fa-solid fa-trophy',
        'Corazón (inclusión)'       => 'fa-solid fa-heart',
        'Medalla (deporte)'         => 'fa-solid fa-medal',
        'Usuarios (familiar/varios)' => 'fa-solid fa-users',
        'Bombilla (innovación)'     => 'fa-solid fa-lightbulb',
        'Mano ayudando'             => 'fa-solid fa-hands-helping',
        'Estrella'                  => 'fa-solid fa-star',
        'Libro'                     => 'fa-solid fa-book',
        'Check'                     => 'fa-solid fa-check',
    ];

    public function index()
    {
        $items       = BecaTipo::orderBy('id', 'asc')->get();
        $iconOptions = $this->iconOptions;

        return view('admin.admision_matricula.beca.tipo.index', compact('items', 'iconOptions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'      => ['required', 'string', 'max:200'],
            'descripcion' => ['required', 'string', 'max:2000'],
            'requisito'   => ['required', 'string', 'max:500'],
            'icono'       => ['required', 'string', 'max:100'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        BecaTipo::create([
            'titulo'      => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'requisito'   => $data['requisito'],
            'icono'       => $data['icono'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('beca-tipo.index')->with('success', 'Beca creada correctamente.');
    }

    public function update(Request $request, BecaTipo $tipo)
    {
        $data = $request->validate([
            'titulo'      => ['required', 'string', 'max:200'],
            'descripcion' => ['required', 'string', 'max:2000'],
            'requisito'   => ['required', 'string', 'max:500'],
            'icono'       => ['required', 'string', 'max:100'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $tipo->update([
            'titulo'      => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'requisito'   => $data['requisito'],
            'icono'       => $data['icono'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('beca-tipo.index')->with('success', 'Beca actualizada correctamente.');
    }

    public function destroy(BecaTipo $tipo)
    {
        $tipo->delete(); // Soft delete
        return redirect()->route('beca-tipo.index')->with('success', 'Beca eliminada.');
    }
}
