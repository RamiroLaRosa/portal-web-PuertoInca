<?php

namespace App\Http\Controllers;

use App\Models\MatriculaTipo;
use Illuminate\Http\Request;

class MatriculaTipoController extends Controller
{
    /** Opciones de íconos para el combo (label => value) */
    private array $iconOptions = [
        'Usuario +'      => 'fa-solid fa-user-plus',
        'Repetir'        => 'fa-solid fa-repeat',
        'Estrella'       => 'fa-solid fa-star',
        'Calendario'     => 'fa-solid fa-calendar',
        'Graduación'     => 'fa-solid fa-graduation-cap',
        'Libro abierto'  => 'fa-solid fa-book-open',
        'Lista'          => 'fa-solid fa-list',
        'Check'          => 'fa-solid fa-check',
    ];

    public function index()
    {
        $items = MatriculaTipo::orderBy('id', 'asc')->get();
        $iconOptions = $this->iconOptions;

        return view('admin.admision_matricula.matricula.tipos.index', compact('items','iconOptions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'      => ['required','string','max:150'],
            'descripcion' => ['required','string','max:500'],
            'icono'       => ['required','string','max:100'],
            'is_active'   => ['nullable','boolean'],
        ]);

        MatriculaTipo::create([
            'titulo'      => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'icono'       => $data['icono'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('matri-tipos.index')->with('success', 'Registro creado.');
    }

    public function update(Request $request, MatriculaTipo $tipo)
    {
        $data = $request->validate([
            'titulo'      => ['required','string','max:150'],
            'descripcion' => ['required','string','max:500'],
            'icono'       => ['required','string','max:100'],
            'is_active'   => ['nullable','boolean'],
        ]);

        $tipo->update([
            'titulo'      => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'icono'       => $data['icono'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('matri-tipos.index')->with('success', 'Registro actualizado.');
    }

    public function destroy(MatriculaTipo $tipo)
    {
        $tipo->delete(); // Soft delete; usa forceDelete() si quieres hard delete
        return redirect()->route('matri-tipos.index')->with('success', 'Registro eliminado.');
    }
}
