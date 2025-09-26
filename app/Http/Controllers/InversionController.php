<?php
// app/Http/Controllers/InversionController.php

namespace App\Http\Controllers;

use App\Models\Inversion;
use App\Models\TipoInversion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InversionController extends Controller
{
    public function index()
    {
        $items = Inversion::with('tipo')->orderBy('id', 'asc')->get();
        $tipos = TipoInversion::orderBy('nombre')->get(['id','nombre']);
        return view('admin.transparencia.inversiones.index', compact('items','tipos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'            => ['required','string','max:200'],
            'descripcion'       => ['required','string'],
            'tipo_inversion_id' => ['required','integer','exists:tipo_inversiones,id'],
            'documento'         => ['nullable','file','mimes:pdf','max:20480'],
            'imagen'            => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'is_active'         => ['nullable','boolean'],
        ]);

        // Guardar en /public/assets
        $docRel = null;
        if ($request->hasFile('documento')) {
            $file     = $request->file('documento');
            $filename = 'INV_DOC_'.Str::random(10).'_'.time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets'), $filename);
            $docRel = 'assets/'.$filename;                 // <- guarda así en BD
        }

        $imgRel = null;
        if ($request->hasFile('imagen')) {
            $img     = $request->file('imagen');
            $fname   = 'INV_IMG_'.Str::random(10).'_'.time().'.'.$img->getClientOriginalExtension();
            $img->move(public_path('assets'), $fname);
            $imgRel = 'assets/'.$fname;                    // <- guarda así en BD
        } else {
            // si quieres guardar exactamente "./images/no-photo.jpg"
            $imgRel = './images/no-photo.jpg';
        }

        Inversion::create([
            'nombre'            => $data['nombre'],
            'descripcion'       => $data['descripcion'],
            'tipo_inversion_id' => $data['tipo_inversion_id'],
            'documento'         => $docRel,
            'imagen'            => $imgRel,
            'is_active'         => $request->boolean('is_active'),
        ]);

        return back()->with('success','Registro creado.');
    }

    public function update(Request $request, Inversion $inversion)
    {
        $data = $request->validate([
            'nombre'            => ['required','string','max:200'],
            'descripcion'       => ['required','string'],
            'tipo_inversion_id' => ['required','integer','exists:tipo_inversiones,id'],
            'documento'         => ['nullable','file','mimes:pdf','max:20480'],
            'imagen'            => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'is_active'         => ['nullable','boolean'],
        ]);

        // reemplazo de PDF
        if ($request->hasFile('documento')) {
            if ($inversion->documento && file_exists(public_path(ltrim($inversion->documento,'./')))) {
                @unlink(public_path(ltrim($inversion->documento,'./')));
            }
            $f = $request->file('documento');
            $name = 'INV_DOC_'.Str::random(10).'_'.time().'.'.$f->getClientOriginalExtension();
            $f->move(public_path('assets'), $name);
            $inversion->documento = 'assets/'.$name;
        }

        // reemplazo de imagen
        if ($request->hasFile('imagen')) {
            if ($inversion->imagen && !str_starts_with($inversion->imagen, './') &&
                file_exists(public_path(ltrim($inversion->imagen,'./')))) {
                @unlink(public_path(ltrim($inversion->imagen,'./')));
            }
            $i = $request->file('imagen');
            $name = 'INV_IMG_'.Str::random(10).'_'.time().'.'.$i->getClientOriginalExtension();
            $i->move(public_path('assets'), $name);
            $inversion->imagen = 'assets/'.$name;
        }

        $inversion->fill([
            'nombre'            => $data['nombre'],
            'descripcion'       => $data['descripcion'],
            'tipo_inversion_id' => $data['tipo_inversion_id'],
            'is_active'         => $request->boolean('is_active'),
        ])->save();

        return back()->with('success','Registro actualizado.');
    }

    public function destroy(Inversion $inversion)
    {
        if ($inversion->documento && file_exists(public_path(ltrim($inversion->documento,'./')))) {
            @unlink(public_path(ltrim($inversion->documento,'./')));
        }
        if ($inversion->imagen && !str_starts_with($inversion->imagen, './') &&
            file_exists(public_path(ltrim($inversion->imagen,'./')))) {
            @unlink(public_path(ltrim($inversion->imagen,'./')));
        }
        $inversion->delete();
        return back()->with('success','Registro eliminado.');
    }
}
