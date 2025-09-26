<?php

namespace App\Http\Controllers;

use App\Models\ProgramasEstudio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgramasEstudioController extends Controller
{
    public function index()
    {
        $programas = ProgramasEstudio::orderBy('id')->get();
        return view('admin.programas_estudios.gestionar_programa.index', compact('programas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => ['required','string','max:150'],
            'descripcion' => ['required','string'],
            'imagen'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'], // 4MB
            'is_active'   => ['nullable','boolean'],
        ]);

        // Subida de imagen (opcional). Guardamos en /public/images/programas
        $ruta = '/images/no-photo.jpg';
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $name = Str::slug($request->nombre).'-'.time().'.'.$file->getClientOriginalExtension();
            $dest = public_path('images/programas');
            if (!is_dir($dest)) mkdir($dest, 0775, true);
            $file->move($dest, $name);
            $ruta = '/images/programas/'.$name;
        }

        ProgramasEstudio::create([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'imagen'      => $ruta,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return back()->with('success','Programa creado correctamente.');
    }

    public function update(Request $request, ProgramasEstudio $programa)
    {
        $data = $request->validate([
            'nombre'      => ['required','string','max:150'],
            'descripcion' => ['required','string'],
            'imagen'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'is_active'   => ['nullable','boolean'],
        ]);

        $ruta = $programa->imagen;
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $name = Str::slug($request->nombre).'-'.time().'.'.$file->getClientOriginalExtension();
            $dest = public_path('images/programas');
            if (!is_dir($dest)) mkdir($dest, 0775, true);
            $file->move($dest, $name);
            $ruta = '/images/programas/'.$name;
        }

        $programa->update([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'imagen'      => $ruta,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return back()->with('success','Programa actualizado correctamente.');
    }

    public function destroy(ProgramasEstudio $programa)
    {
        $programa->delete();
        return back()->with('success','Programa eliminado.');
    }
}
