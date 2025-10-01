<?php

namespace App\Http\Controllers;

use App\Models\Local;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LocalController extends Controller
{
    public function index()
    {
        $locales = Local::orderBy('id')->get();
        return view('admin.nosotros.local.index', compact('locales'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'direccion' => ['required', 'string', 'max:255'],
            'telefono'  => ['required', 'string', 'max:50'],
            'correo'    => ['required', 'email', 'max:255'],
            'horario'   => ['required', 'string', 'max:100'],
            'link'      => ['required', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'foto'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('foto')) {
            $folder   = 'images/institucion/locales';
            $ext      = $request->file('foto')->getClientOriginalExtension();
            $filename = Str::uuid() . '.' . $ext;

            if (!is_dir(public_path($folder))) {
                @mkdir(public_path($folder), 0755, true);
            }

            $request->file('foto')->move(public_path($folder), $filename);
            $data['foto'] = $folder . '/' . $filename;
        }

        Local::create($data);

        return redirect()->route('local.index')->with('success', 'Local creado correctamente.');
    }

    public function update(Request $request, Local $local)
    {
        $data = $request->validate([
            'direccion' => ['required', 'string', 'max:255'],
            'telefono'  => ['required', 'string', 'max:50'],
            'correo'    => ['required', 'email', 'max:255'],
            'horario'   => ['required', 'string', 'max:100'],
            'link'      => ['required', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'foto'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('foto')) {
            $folder   = 'images/institucion/locales';
            $ext      = $request->file('foto')->getClientOriginalExtension();
            $filename = Str::uuid() . '.' . $ext;

            if (!is_dir(public_path($folder))) {
                @mkdir(public_path($folder), 0755, true);
            }

            $request->file('foto')->move(public_path($folder), $filename);
            $data['foto'] = $folder . '/' . $filename;

            if ($local->foto && file_exists(public_path($local->foto))) {
                @unlink(public_path($local->foto));
            }
        }

        $local->update($data);

        return back()->with('success', 'Registro actualizado correctamente.');
    }

    public function destroy(Local $local)
    {
        if ($local->foto && file_exists(public_path($local->foto))) {
            @unlink(public_path($local->foto));
        }
        $local->delete();

        return redirect()->route('local.index')->with('success', 'Local eliminado.');
    }
}
