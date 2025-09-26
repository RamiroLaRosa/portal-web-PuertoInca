<?php

// app/Http/Controllers/InicioServiciosController.php
namespace App\Http\Controllers;

use App\Models\InicioServicio;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InicioServiciosController extends Controller
{
    // Ya lo usaste para "Nuevo servicio"
    public const ICONS = [
        'fa-solid fa-book'       => 'Libro',
        'fa-solid fa-book-open'  => 'Libro (abierto)',
        'fa-solid fa-laptop'     => 'Laptop',
        'fa-solid fa-users'      => 'Usuarios',
        'fa-solid fa-user-group' => 'Grupo',
        'fa-solid fa-flask'      => 'Laboratorio',
        'fa-solid fa-building'   => 'Edificio',
        'fa-solid fa-briefcase'  => 'Portafolio',
        'fa-solid fa-graduation-cap' => 'Graduación',
    ];

    public function index()
    {
        $servicios = InicioServicio::orderBy('id')->get();
        $icons = self::ICONS;
        return view('admin.inicio.Servicios.index', compact('servicios', 'icons'));
    }

    public function store(Request $request)
    {
        $validIconValues = array_keys(self::ICONS);

        $validated = $request->validate([
            'nombre'      => ['required', 'string', 'max:150'],
            'descripcion' => ['required', 'string', 'max:500'],
            'icono'       => ['required', 'string', Rule::in($validIconValues)],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        InicioServicio::create([
            'nombre'      => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
            'icono'       => $validated['icono'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('servicios-inicio.index')->with('success', 'Servicio creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $servicio = InicioServicio::findOrFail($id);
        $validIconValues = array_keys(self::ICONS);

        $validated = $request->validate([
            'nombre'      => ['required', 'string', 'max:150'],
            'descripcion' => ['required', 'string', 'max:500'],
            'icono'       => ['required', 'string', Rule::in($validIconValues)],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $servicio->update([
            'nombre'      => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
            'icono'       => $validated['icono'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('servicios-inicio.index')->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy($id)
    {
        $servicio = \App\Models\InicioServicio::findOrFail($id);
        $servicio->delete(); // Soft delete (usa deleted_at)
        return redirect()
            ->route('servicios-inicio.index')
            ->with('success', 'Servicio eliminado correctamente.');
    }
}
