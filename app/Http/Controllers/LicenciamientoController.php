<?php

namespace App\Http\Controllers;

use App\Models\Licenciamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LicenciamientoController extends Controller
{
    public function index()
    {
        $items = Licenciamiento::orderBy('id')->get();

        return view('admin.transparencia.licenciamiento.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => ['required', 'string', 'max:200'],
            'descripcion' => ['required', 'string'],
            'documento'   => ['nullable', 'file', 'mimes:pdf', 'max:20480'], // 20MB
            'is_active'   => ['nullable', 'boolean'],
        ]);

        // Guardar PDF en public/assets y persistir la ruta relativa "assets/xxx.pdf"
        $docPath = null;
        if ($request->hasFile('documento')) {
            $dir = public_path('assets');
            if (!is_dir($dir)) {
                @mkdir($dir, 0775, true);
            }
            $file = $request->file('documento');
            $name = 'LIC_DOC_' . Str::random(12) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $name);
            $docPath = 'assets/' . $name;
        }

        Licenciamiento::create([
            'nombre'      => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'documento'   => $docPath,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Registro creado correctamente.');
    }

    public function update(Request $request, Licenciamiento $licenciamiento)
    {
        $data = $request->validate([
            'nombre'      => ['required', 'string', 'max:200'],
            'descripcion' => ['required', 'string'],
            'documento'   => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        // Si envía un nuevo PDF, reemplazar
        if ($request->hasFile('documento')) {
            $dir = public_path('assets');
            if (!is_dir($dir)) {
                @mkdir($dir, 0775, true);
            }

            // Borrar archivo anterior si existiera
            if ($licenciamiento->documento && file_exists(public_path($licenciamiento->documento))) {
                @unlink(public_path($licenciamiento->documento));
            }

            $file = $request->file('documento');
            $name = 'LIC_DOC_' . Str::random(12) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $name);
            $licenciamiento->documento = 'assets/' . $name;
        }

        $licenciamiento->nombre      = $data['nombre'];
        $licenciamiento->descripcion = $data['descripcion'];
        $licenciamiento->is_active   = $request->boolean('is_active');
        $licenciamiento->save();

        return back()->with('success', 'Registro actualizado correctamente.');
    }

    public function destroy(Licenciamiento $licenciamiento)
    {
        // (Opcional) Si deseas eliminar físicamente el PDF:
        // if ($licenciamiento->documento && file_exists(public_path($licenciamiento->documento))) {
        //     @unlink(public_path($licenciamiento->documento));
        // }

        $licenciamiento->delete();

        return back()->with('success', 'Registro eliminado correctamente.');
    }
}
