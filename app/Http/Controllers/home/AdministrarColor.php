<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;

class AdministrarColor extends Controller
{
    public function guardarcolor(Request $request)
    {
        $data = $request->validate([
            'color-primario-p1' => 'required|string|size:7',
            'color-primario-p2' => 'required|string|size:7',
            'color-primario-p3' => 'required|string|size:7',
            'color-secundario-s1' => 'required|string|size:7',
            'color-neutral' => 'required|string|size:7',
        ]);

        foreach ($data as $clave => $valor) {
            \App\Models\Color::updateOrCreate(['clave' => $clave], ['valor' => $valor]);
        }

        return back()->with('success', 'Colores actualizados correctamente.');
    }
}
