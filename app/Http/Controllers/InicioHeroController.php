<?php

// app/Http/Controllers/InicioHeroController.php
namespace App\Http\Controllers;

use App\Models\InicioHero;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InicioHeroController extends Controller
{
    public function index()
    {
        // si quieres solo activos: ->where('is_active', 1)
        $heroes = InicioHero::orderBy('id')->get();

        return view('admin.inicio.hero.index', compact('heroes'));
    }

    // app/Http/Controllers/InicioHeroController.php
    public function update(Request $request, $id)
    {
        $hero = InicioHero::findOrFail($id);

        $validated = $request->validate([
            'titulo'      => ['required', 'string', 'max:150'],
            'descripcion' => ['required', 'string', 'max:500'],
            'is_active'   => ['nullable', 'boolean'],
            'foto'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $hero->fill([
            'titulo'      => $validated['titulo'],
            'descripcion' => $validated['descripcion'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        if ($request->hasFile('foto')) {
            $dir = 'images/hero';
            $file = $request->file('foto');
            $filename = time() . '_' . \Illuminate\Support\Str::slug(substr($hero->titulo, 0, 40)) . '.' . $file->extension();
            $file->move(public_path($dir), $filename);
            $hero->foto = $dir . '/' . $filename;
        }

        $hero->save();

        return redirect()->route('hero.index')->with('success', 'Sección actualizada correctamente.');
    }
}
