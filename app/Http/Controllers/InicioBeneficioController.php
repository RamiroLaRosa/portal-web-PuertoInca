<?php

// app/Http/Controllers/InicioBeneficioController.php
namespace App\Http\Controllers;

use App\Models\InicioBeneficio;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InicioBeneficioController extends Controller
{
    // Valor guardado en BD => etiqueta visible en el combo
    public const ICONS = [
        'fa-solid fa-lightbulb'  => 'Innovación',
        'fa-solid fa-globe'      => 'Globo',
        'fa-solid fa-rocket'     => 'Cohete',
        'fa-solid fa-user-group' => 'Comunidad',
        'fa-solid fa-bolt'       => 'Rendimiento',
        'fa-solid fa-briefcase'  => 'Portafolio',
        'fa-solid fa-award'      => 'Reconocimiento',
        'fa-solid fa-graduation-cap' => 'Graduación',
        'fa-solid fa-book'       => 'Libro',
    ];

    public function index()
    {
        $beneficios = InicioBeneficio::orderBy('id')->get();
        $icons = self::ICONS;
        return view('admin.inicio.beneficio.index', compact('beneficios','icons'));
    }

    public function store(Request $request)
    {
        $validIcons = array_keys(self::ICONS);

        $data = $request->validate([
            'nombre'      => ['required','string','max:150'],
            'descripcion' => ['required','string','max:500'],
            'icono'       => ['required','string', Rule::in($validIcons)],
            'is_active'   => ['nullable','boolean'],
        ]);

        InicioBeneficio::create([
            'nombre'      => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'icono'       => $data['icono'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('beneficio.index')->with('success','Beneficio creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $beneficio = InicioBeneficio::findOrFail($id);
        $validIcons = array_keys(self::ICONS);

        $data = $request->validate([
            'nombre'      => ['required','string','max:150'],
            'descripcion' => ['required','string','max:500'],
            'icono'       => ['required','string', Rule::in($validIcons)],
            'is_active'   => ['nullable','boolean'],
        ]);

        $beneficio->update([
            'nombre'      => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'icono'       => $data['icono'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('beneficio.index')->with('success','Beneficio actualizado correctamente.');
    }

    public function destroy($id)
    {
        $beneficio = InicioBeneficio::findOrFail($id);
        $beneficio->delete(); // SoftDelete (deleted_at)
        return redirect()->route('beneficio.index')->with('success','Beneficio eliminado correctamente.');
    }
}
