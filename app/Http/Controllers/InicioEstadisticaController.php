<?php

// app/Http/Controllers/InicioEstadisticaController.php
namespace App\Http\Controllers;

use App\Models\InicioEstadistica;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InicioEstadisticaController extends Controller
{
    // Valor guardado en BD => etiqueta visible
    public const ICONS = [
        'fa-solid fa-user-group'   => 'Estudiantes',
        'fa-solid fa-graduation-cap' => 'Egresados',
        'fa-solid fa-award'        => 'Años de servicio',
        'fa-solid fa-briefcase'    => 'Programas',
        'fa-solid fa-users'        => 'Usuarios',
        'fa-solid fa-building'     => 'Edificio',
        'fa-solid fa-flask'        => 'Laboratorio',
        'fa-solid fa-book'         => 'Libro',
        'fa-solid fa-book-open'    => 'Libro (abierto)',
    ];

    public function index()
    {
        $stats = InicioEstadistica::orderBy('id')->get();
        $icons = self::ICONS;

        return view('admin.inicio.estadistica.index', compact('stats', 'icons'));
    }

    public function store(Request $request)
    {
        $validIconValues = array_keys(self::ICONS);

        $data = $request->validate([
            'icono'       => ['required', 'string', Rule::in($validIconValues)],
            'descripcion' => ['required', 'string', 'max:255'],
            'cantidad'    => ['required', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        InicioEstadistica::create([
            'icono'       => $data['icono'],
            'descripcion' => $data['descripcion'],
            'cantidad'    => $data['cantidad'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('estadistica-inicio.index')->with('success', 'Registro creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $stat = InicioEstadistica::findOrFail($id);
        $validIconValues = array_keys(self::ICONS);

        $data = $request->validate([
            'icono'       => ['required', 'string', Rule::in($validIconValues)],
            'descripcion' => ['required', 'string', 'max:255'],
            'cantidad'    => ['required', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $stat->update([
            'icono'       => $data['icono'],
            'descripcion' => $data['descripcion'],
            'cantidad'    => $data['cantidad'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('estadistica-inicio.index')->with('success', 'Registro actualizado correctamente.');
    }

    public function destroy($id)
    {
        $stat = InicioEstadistica::findOrFail($id);
        $stat->delete();

        return redirect()->route('estadistica-inicio.index')->with('success', 'Registro eliminado correctamente.');
    }
}
