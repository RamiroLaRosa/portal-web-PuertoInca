<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramasGaleria;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ProgramasGaleriaController extends Controller
{
    // LISTAR por programa
    public function index(int $programa)
    {
        $rows = ProgramasGaleria::where('programa_id', $programa)
            ->where(function ($q) { $q->whereNull('is_active')->orWhere('is_active', 1); })
            ->orderBy('id')->get();

        return response()->json([
            'ok' => true,
            'galeria' => $rows->map(fn($r) => [
                'id'         => $r->id,
                'nombre'     => $r->nombre,
                'imagen_url' => $r->imagen_url,
            ]),
        ]);
    }

    // VER uno
    public function show(int $programa, int $item)
    {
        $r = ProgramasGaleria::where('programa_id', $programa)->findOrFail($item);
        return response()->json([
            'ok' => true,
            'item' => [
                'id'         => $r->id,
                'nombre'     => $r->nombre,
                'imagen_url' => $r->imagen_url,
            ],
        ]);
    }

    // CREAR
    public function store(Request $request, int $programa)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|image|max:4096',
        ]);

        $img = $this->saveImage($request->file('imagen'), null);

        $r = ProgramasGaleria::create([
            'programa_id' => $programa,
            'nombre'      => $data['nombre'],
            'imagen'      => $img,
            'is_active'   => 1,
        ]);

        return response()->json(['ok' => true, 'id' => $r->id]);
    }

    // ACTUALIZAR (POST para compatibilidad con FormData)
    public function update(Request $request, int $programa, int $item)
    {
        $r = ProgramasGaleria::where('programa_id', $programa)->findOrFail($item);

        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|image|max:4096',
        ]);

        $r->nombre = $data['nombre'];
        if ($request->hasFile('imagen')) {
            $r->imagen = $this->saveImage($request->file('imagen'), $r->imagen);
        }
        $r->save();

        return response()->json(['ok' => true]);
    }

    // ELIMINAR
    public function destroy(int $programa, int $item)
    {
        $r = ProgramasGaleria::where('programa_id', $programa)->findOrFail($item);

        if ($r->imagen && str_starts_with($r->imagen, '/images/')) {
            $file = public_path(ltrim($r->imagen, '/'));
            if (is_file($file)) @unlink($file);
        }

        $r->delete();
        return response()->json(['ok' => true]);
    }

    // Guardar imagen en /public/images
    private function saveImage(?UploadedFile $file, ?string $current): ?string
    {
        if (!$file) return $current;

        $dir = public_path('images');
        if (!is_dir($dir)) @mkdir($dir, 0775, true);

        $ext  = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $name = 'IMG_' . uniqid() . '.' . $ext;
        $file->move($dir, $name);

        if ($current && str_starts_with($current, '/images/')) {
            $old = public_path(ltrim($current, '/'));
            if (is_file($old)) @unlink($old);
        }

        return '/images/' . $name;
    }
}
