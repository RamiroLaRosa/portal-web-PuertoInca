<?php

// app/Http/Controllers/MisionVisionController.php
namespace App\Http\Controllers;

use App\Models\Mision;
use App\Models\Vision;
use App\Models\Valor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MisionVisionController extends Controller
{
    public function index()
    {
        $mision = Mision::first() ?? Mision::create(['descripcion' => '']);
        $vision = Vision::first() ?? Vision::create(['descripcion' => '']);
        $valores = Valor::orderBy('id')->get();

        $iconOptions = [
            'Estrella'      => 'fa-solid fa-star',
            'Corazón'       => 'fa-solid fa-heart',
            'Rayo'          => 'fa-solid fa-bolt',
            'Libro'         => 'fa-solid fa-book',
            'Usuarios'      => 'fa-solid fa-users',
            'Globo'         => 'fa-solid fa-globe',
            'Medalla'       => 'fa-solid fa-award',
            'Maletín'       => 'fa-solid fa-briefcase',
            'Escudo'        => 'fa-solid fa-shield-halved',
            'Cohete'        => 'fa-solid fa-rocket',
            'Bombilla'      => 'fa-solid fa-lightbulb',
            'Laptop'        => 'fa-solid fa-laptop',
            'Persona'       => 'fa-solid fa-user',
            'Equipo'        => 'fa-solid fa-user-group',
            'Frasco'        => 'fa-solid fa-flask',
            'Edificio'      => 'fa-solid fa-building',
        ];

        return view('admin.nosotros.mision.index', compact('mision','vision','valores','iconOptions'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'mision_descripcion' => ['required','string','max:5000'],
            'vision_descripcion' => ['required','string','max:5000'],
        ]);

        DB::transaction(function () use ($data) {
            $m = Mision::first() ?? new Mision();
            $m->descripcion = $data['mision_descripcion'];
            $m->save();

            $v = Vision::first() ?? new Vision();
            $v->descripcion = $data['vision_descripcion'];
            $v->save();
        });

        return redirect()->route('mv.index')->with('success','Contenido actualizado correctamente.');
    }

    public function showPublic()
    {
        // Trae el único registro (o vacío si no existiera)
        $mision = Mision::first() ?? new Mision(['descripcion' => '']);
        $vision = Vision::first() ?? new Vision(['descripcion' => '']);

        // Solo valores activos, ordenados como los tienes
        $valores = Valor::where('is_active', true)->orderBy('id')->get();

        return view('nosotros.mision', compact('mision', 'vision', 'valores'));
    }
}
