<?php

namespace App\Http\Controllers;

use App\Models\AdmisionTitulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdmisionTituloController extends Controller
{
    public function index()
    {
        $items = AdmisionTitulo::latest('id')->get();
        return view('admin.admision_matricula.admision.titulo.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'      => ['required','string','max:200'],
            'descripcion' => ['required','string'],
            'imagen'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'is_active'   => ['nullable','boolean'],
        ]);

        $path = 'images/no-photo.jpg';

        if ($request->hasFile('imagen')) {
            // guarda en storage/app/public/admision_titulo
            $path = $request->file('imagen')->store('admision_titulo', 'public');
        }

        AdmisionTitulo::create([
            'titulo'      => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'imagen'      => $path,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admision-titulo.index')->with('success','Registro creado.');
    }

    public function update(Request $request, AdmisionTitulo $admision_titulo)
    {
        $data = $request->validate([
            'titulo'      => ['required','string','max:200'],
            'descripcion' => ['required','string'],
            'imagen'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'is_active'   => ['nullable','boolean'],
        ]);

        $admision_titulo->fill([
            'titulo'      => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        if ($request->hasFile('imagen')) {
            $prev = $admision_titulo->getOriginal('imagen');
            $path = $request->file('imagen')->store('admision_titulo', 'public');

            if ($prev && $prev !== 'images/no-photo.jpg' && Storage::disk('public')->exists($prev)) {
                Storage::disk('public')->delete($prev);
            }

            $admision_titulo->imagen = $path;
        }

        $admision_titulo->save();

        return redirect()->route('admin-titulo.index')->with('success','Registro actualizado.');
    }

    public function destroy(AdmisionTitulo $admision_titulo)
    {
        $admision_titulo->delete();
        return redirect()->route('admin-titulo.index')->with('success','Registro eliminado.');
    }
}
