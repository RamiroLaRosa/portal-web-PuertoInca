<?php

// app/Http/Controllers/ReseniaController.php
namespace App\Http\Controllers;

use App\Models\Resenia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReseniaController extends Controller
{
    public function index()
    {
        $items = Resenia::orderBy('id')->get();
        return view('admin.nosotros.resenia.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'      => ['required','string','max:200'],
            'descripcion' => ['required','string'],
            'imagen'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'is_active'   => ['nullable','boolean'],
        ]);

        $ruta = 'images/no-photo.jpg';
        if ($request->hasFile('imagen')) {
            $dir = 'images/resenia';
            if (!is_dir(public_path($dir))) @mkdir(public_path($dir), 0775, true);
            $file = $request->file('imagen');
            $filename = time().'_'.Str::slug(substr($data['titulo'],0,40)).'.'.$file->extension();
            $file->move(public_path($dir), $filename);
            $ruta = $dir.'/'.$filename;
        }

        Resenia::create([
            'titulo'      => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'imagen'      => $ruta,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('resenia.index')->with('success','Registro creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $r = Resenia::findOrFail($id);

        $data = $request->validate([
            'titulo'      => ['required','string','max:200'],
            'descripcion' => ['required','string'],
            'imagen'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'is_active'   => ['nullable','boolean'],
        ]);

        $r->fill([
            'titulo'      => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        if ($request->hasFile('imagen')) {
            $dir = 'images/resenia';
            if (!is_dir(public_path($dir))) @mkdir(public_path($dir), 0775, true);
            $file = $request->file('imagen');
            $filename = time().'_'.Str::slug(substr($data['titulo'],0,40)).'.'.$file->extension();
            $file->move(public_path($dir), $filename);
            $prev = ltrim($r->getOriginal('imagen') ?? '', './');
            if ($prev && $prev !== 'images/no-photo.jpg' && file_exists(public_path($prev))) @unlink(public_path($prev));
            $r->imagen = $dir.'/'.$filename;
        }

        $r->save();

        return redirect()->route('resenia.index')->with('success','Registro actualizado correctamente.');
    }

    public function destroy($id)
    {
        $r = Resenia::findOrFail($id);
        $r->delete(); // SoftDelete
        return redirect()->route('resenia.index')->with('success','Registro eliminado correctamente.');
    }
}
