<?php

namespace App\Http\Controllers;

use App\Models\PlanaJerarquica;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JerarquicaController extends Controller
{
    public function index()
    {
        $items = PlanaJerarquica::orderBy('id')->get();

        return view('admin.nosotros.jerarquica.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'cargo'  => ['required', 'string', 'max:150'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_active' => ['required','boolean'],
        ]);

        // Subida de imagen (opcional)
        $path = '/images/no-photo.jpg';
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = 'jerarquica_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/jerarquica'), $filename);
            $path = '/images/jerarquica/' . $filename;
        }

        PlanaJerarquica::create([
            'nombre'    => $data['nombre'],
            'cargo'     => $data['cargo'],
            'imagen'    => $path,
            'is_active' => $request->boolean('is_active') ? 1 : 0,
        ]);

        return redirect()->route('jerarquica.index')->with('success', 'Coordinador creado.');
    }

    public function update(Request $request, $id)
    {
        $item = PlanaJerarquica::findOrFail($id);

        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'cargo'  => ['required', 'string', 'max:150'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_active' => ['required','boolean'],
        ]);

        $payload = [
            'nombre'    => $data['nombre'],
            'cargo'     => $data['cargo'],
            'is_active' => $request->boolean('is_active') ? 1 : 0,
        ];

        if ($request->hasFile('imagen')) {
            // elimina anterior si no es el placeholder
            if (!empty($item->imagen) && $item->imagen !== '/images/no-photo.jpg') {
                $old = public_path(ltrim($item->imagen, '/'));
                if (is_file($old)) @unlink($old);
            }
            $file = $request->file('imagen');
            $filename = 'jerarquica_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/jerarquica'), $filename);
            $payload['imagen'] = '/images/jerarquica/' . $filename;
        }

        $item->update($payload);

        return redirect()->route('jerarquica.index')->with('success', 'Coordinador actualizado.');
    }

    public function destroy($id)
    {
        $item = PlanaJerarquica::findOrFail($id);
        $item->delete();

        return redirect()->route('jerarquica.index')->with('success', 'Coordinador eliminado.');
    }

    public function showPublic()
    {
        $items = \App\Models\PlanaJerarquica::where('is_active', 1)
            ->orderBy('id')
            ->get();

        return view('nosotros.jerarquica', compact('items'));
    }
}
