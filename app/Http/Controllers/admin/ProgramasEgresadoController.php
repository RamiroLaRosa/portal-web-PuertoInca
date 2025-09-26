<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramasEgresado;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ProgramasEgresadoController extends Controller
{
    /**
     * Lista egresados por programa.
     */
    public function index($programa)
    {
        $rows = ProgramasEgresado::where('programa_id', $programa)
            ->where(function ($q) {
                $q->whereNull('is_active')->orWhere('is_active', 1);
            })
            ->orderBy('id')
            ->get();

        return response()->json([
            'ok' => true,
            'egresados' => $rows->map(fn ($g) => [
                'id'         => $g->id,
                'nombre'     => $g->nombre,
                'cargo'      => $g->cargo,
                'imagen_url' => $g->imagen_url,
            ]),
        ]);
    }

    /**
     * Obtiene un egresado por ID (para el modal de edición y para ver imagen).
     */
    public function show($programa, $egresado)
    {
        $g = ProgramasEgresado::where('programa_id', $programa)->findOrFail($egresado);

        return response()->json([
            'ok' => true,
            'egresado' => [
                'id'         => $g->id,
                'nombre'     => $g->nombre,
                'cargo'      => $g->cargo,
                'imagen_url' => $g->imagen_url,
            ],
        ]);
    }

    /**
     * Crea un nuevo egresado.
     * Espera: nombre, cargo, (imagen opcional)
     */
    public function store(Request $request, $programa)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'cargo'  => 'required|string|max:255',
            'imagen' => 'nullable|image|max:4096',
        ]);

        $imgPath = $this->saveImage($request->file('imagen'), null);

        $g = ProgramasEgresado::create([
            'programa_id' => (int)$programa,
            'nombre'      => $data['nombre'],
            'cargo'       => $data['cargo'],
            'imagen'      => $imgPath,
            'is_active'   => 1,
        ]);

        return response()->json(['ok' => true, 'id' => $g->id]);
    }

    /**
     * Actualiza un egresado por ID.
     * Puede venir o no nueva imagen.
     */
    public function update(Request $request, $programa, $egresado)
    {
        $g = ProgramasEgresado::where('programa_id', $programa)->findOrFail($egresado);

        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'cargo'  => 'required|string|max:255',
            'imagen' => 'nullable|image|max:4096',
        ]);

        $g->nombre = $data['nombre'];
        $g->cargo  = $data['cargo'];

        if ($request->hasFile('imagen')) {
            $g->imagen = $this->saveImage($request->file('imagen'), $g->imagen);
        }

        $g->save();

        return response()->json(['ok' => true]);
    }

    /**
     * Elimina un egresado por ID (y su imagen física si aplica).
     */
    public function destroy($programa, $egresado)
    {
        $g = ProgramasEgresado::where('programa_id', $programa)->findOrFail($egresado);

        // elimina archivo físico solo si está dentro de /images
        if ($g->imagen && str_starts_with($g->imagen, '/images/')) {
            $file = public_path(ltrim($g->imagen, '/'));
            if (is_file($file)) @unlink($file);
        }

        $g->delete();

        return response()->json(['ok' => true]);
    }

    /**
     * Guarda una imagen en /public/images y devuelve la ruta pública (/images/xxx.ext).
     * Si $current tiene una imagen previa dentro de /images, la elimina.
     */
    private function saveImage(?UploadedFile $file, ?string $current): ?string
    {
        if (!$file) return $current;

        $dir = public_path('images');
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }

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
