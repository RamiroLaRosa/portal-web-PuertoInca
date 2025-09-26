<?php

namespace App\Http\Controllers;

use App\Models\Local;
use Illuminate\Http\Request;

class LocalController extends Controller
{
    public function index()
    {
        $locales = Local::orderBy('id')->get();

        return view('admin.nosotros.local.index', compact('locales'));
    }

    public function update(Request $request, Local $local)
    {
        $data = $request->validate([
            'direccion' => ['required','string','max:255'],
            'telefono'  => ['required','string','max:50'],
            'correo'    => ['required','email','max:255'],
            'horario'   => ['required','string','max:100'],
            'link'      => ['required','string'], // aquí va el iframe completo como texto
            'is_active' => ['nullable','boolean'],
        ]);

        // normalizamos is_active
        $data['is_active'] = $request->boolean('is_active');

        $local->update($data);

        return back()->with('success', 'Registro actualizado correctamente.');
    }
}
