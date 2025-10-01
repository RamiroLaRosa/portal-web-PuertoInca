<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class LogoController extends Controller
{
    // GET /admin/inicio/hero-image
    public function index()
    {
        $record = Logo::orderBy('id', 'desc')->first();
        return view('admin.inicio.logo.index', compact('record'));
    }

    // POST /admin/inicio/hero-image
    public function store(Request $request)
    {
        $request->validate([
            'foto'      => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active' => ['nullable', 'in:1'],
        ]);

        $path = $this->guardarArchivo($request);

        $logo = Logo::create([
            'imagen'    => $path, // "images/xxx.ext"
            'is_active' => $request->boolean('is_active'),
        ]);

        // Si se marcó como activo, desactiva los demás
        if ($request->boolean('is_active')) {
            Logo::where('id', '!=', $logo->id)->update(['is_active' => false]);
        }

        // Olvida la caché para que el header use el nuevo logo
        Cache::forget('site_logo_url');

        return redirect()->route('admin.inicio.logo.index')
            ->with('success', 'Imagen subida correctamente.');
    }

    // PUT /admin/inicio/hero-image/{logo}
    public function update(Request $request, Logo $logo)
    {
        $request->validate([
            'foto'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active' => ['nullable', 'in:1'],
        ]);

        if ($request->hasFile('foto')) {
            $nuevoPath = $this->guardarArchivo($request);
            $this->borrarAnterior($logo->imagen);
            $logo->imagen = $nuevoPath;
        }

        $logo->is_active = $request->boolean('is_active');
        $logo->save();

        // Si se marcó como activo, desactiva los demás
        if ($request->boolean('is_active')) {
            Logo::where('id', '!=', $logo->id)->update(['is_active' => false]);
        }

        // Olvida la caché para que el header use el nuevo logo
        Cache::forget('site_logo_url');

        return redirect()->route('admin.inicio.logo.index')
            ->with('success', 'Imagen actualizada correctamente.');
    }

    private function guardarArchivo(Request $request): string
    {
        $file = $request->file('foto');
        $name = now()->format('Ymd_His_') . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        // Guarda directamente en /public/images
        $file->move(public_path('images'), $name);

        // Devolvemos la ruta relativa que asset() convierte en URL pública
        return 'images/' . $name;
    }

    private function borrarAnterior(?string $ruta): void
    {
        if (!$ruta) return;
        $full = public_path($ruta); // espera "images/xxx.ext"
        if (file_exists($full)) {
            @unlink($full);
        }
    }
}
