<?php

namespace App\Http\Controllers;

use App\Models\MatriculaCronograma;
use Illuminate\Http\Request;

class MatriculaCronogramaController extends Controller
{
    /** Opciones de iconos para el combo (label => value) */
    private array $iconOptions = [
        'Calendario' => 'fa-solid fa-calendar',
        'Usuarios'   => 'fa-solid fa-users',
        'Reloj'      => 'fa-solid fa-clock',
        'Play'       => 'fa-solid fa-play',
        'Lista'      => 'fa-solid fa-list',
        'Check'      => 'fa-solid fa-check',
        'Estrella'   => 'fa-solid fa-star',
        'Libro'      => 'fa-solid fa-book',
    ];

    public function index()
    {
        $items = MatriculaCronograma::orderBy('id', 'asc')->get();
        $iconOptions = $this->iconOptions;

        return view('admin.admision_matricula.matricula.cronograma.index', compact('items','iconOptions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'      => ['required','string','max:200'],
            'fecha'       => ['required','string','max:100'],
            'descripcion' => ['required','string','max:255'],
            'icono'       => ['required','string','max:100'],
            'is_active'   => ['nullable','boolean'],
        ]);

        MatriculaCronograma::create([
            'titulo'      => $data['titulo'],
            'fecha'       => $data['fecha'],
            'descripcion' => $data['descripcion'],
            'icono'       => $data['icono'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('matri-cronograma.index')->with('success', 'Registro creado.');
    }

    public function update(Request $request, MatriculaCronograma $cronograma)
    {
        $data = $request->validate([
            'titulo'      => ['required','string','max:200'],
            'fecha'       => ['required','string','max:100'],
            'descripcion' => ['required','string','max:255'],
            'icono'       => ['required','string','max:100'],
            'is_active'   => ['nullable','boolean'],
        ]);

        $cronograma->update([
            'titulo'      => $data['titulo'],
            'fecha'       => $data['fecha'],
            'descripcion' => $data['descripcion'],
            'icono'       => $data['icono'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('matri-cronograma.index')->with('success', 'Registro actualizado.');
    }

    public function destroy(MatriculaCronograma $cronograma)
    {
        $cronograma->delete(); // Soft delete
        return redirect()->route('matri-cronograma.index')->with('success', 'Registro eliminado.');
    }
}
