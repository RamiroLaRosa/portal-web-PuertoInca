<?php

// app/Http/Controllers/InicioTestimoniosController.php
namespace App\Http\Controllers;

use App\Models\InicioTestimonio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InicioTestimoniosController extends Controller
{
    public function index()
    {
        $testimonios = InicioTestimonio::orderBy('id')->get();
        return view('admin.inicio.testimonios.index', compact('testimonios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => ['required','string','max:150'],
            'descripcion' => ['required','string','max:800'],
            'puntuacion'  => ['required','integer','min:1','max:5'],
            'imagen'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'is_active'   => ['nullable','boolean'],
        ]);

        $rutaRelativa = 'images/no-photo.jpg'; // por defecto
        if ($request->hasFile('imagen')) {
            $dir = 'images/testimonios'; // public/images/testimonios
            if (!is_dir(public_path($dir))) {
                @mkdir(public_path($dir), 0775, true);
            }
            $file = $request->file('imagen');
            $filename = time().'_'.Str::slug(substr($data['nombre'],0,40)).'.'.$file->extension();
            $file->move(public_path($dir), $filename);
            $rutaRelativa = $dir.'/'.$filename;
        }

        InicioTestimonio::create([
            'nombre'      => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'imagen'      => $rutaRelativa,
            'puntuacion'  => $data['puntuacion'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('testimonios.index')->with('success','Testimonio creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $t = InicioTestimonio::findOrFail($id);

        $data = $request->validate([
            'nombre'      => ['required','string','max:150'],
            'descripcion' => ['required','string','max:800'],
            'puntuacion'  => ['required','integer','min:1','max:5'],
            'imagen'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'is_active'   => ['nullable','boolean'],
        ]);

        $t->fill([
            'nombre'      => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'puntuacion'  => $data['puntuacion'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        if ($request->hasFile('imagen')) {
            $dir = 'images/testimonios';
            if (!is_dir(public_path($dir))) {
                @mkdir(public_path($dir), 0775, true);
            }
            $file = $request->file('imagen');
            $filename = time().'_'.Str::slug(substr($data['nombre'],0,40)).'.'.$file->extension();
            $file->move(public_path($dir), $filename);

            // opcional: borrar imagen anterior si no es la por defecto
            $anterior = ltrim($t->getOriginal('imagen'), './');
            if ($anterior && $anterior !== 'images/no-photo.jpg' && file_exists(public_path($anterior))) {
                @unlink(public_path($anterior));
            }

            $t->imagen = $dir.'/'.$filename;
        }

        $t->save();

        return redirect()->route('testimonios.index')->with('success','Testimonio actualizado correctamente.');
    }

    public function destroy($id)
    {
        $t = InicioTestimonio::findOrFail($id);
        $t->delete(); // SoftDelete
        return redirect()->route('testimonios.index')->with('success','Testimonio eliminado correctamente.');
    }
}
