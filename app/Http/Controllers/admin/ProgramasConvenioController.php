<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramasConvenio;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ProgramasConvenioController extends Controller
{
    /**
     * Lista convenios por programa (solo lectura).
     */
    public function index(int $programa)
    {
        $rows = ProgramasConvenio::where('programa_id', $programa)
            ->where(function ($q) {
                $q->whereNull('is_active')->orWhere('is_active', 1);
            })
            ->orderBy('id')
            ->get();

        return response()->json([
            'ok'        => true,
            'convenios' => $rows->map(fn($c) => [
                'id'         => $c->id,
                'entidad'    => $c->entidad,
                'imagen_url' => $c->imagen_url,
            ]),
        ]);
    }

    /**
     * Mostrar un convenio (por ID del convenio y del programa).
     */
    public function show(int $programa, int $convenio)
    {
        $c = ProgramasConvenio::where('programa_id', $programa)->findOrFail($convenio);

        return response()->json([
            'ok' => true,
            'convenio' => [
                'id'         => $c->id,
                'entidad'    => $c->entidad,
                'imagen_url' => $c->imagen_url,
            ],
        ]);
    }

    /**
     * Crear convenio.
     */
    public function store(Request $request, int $programa)
    {
        $data = $request->validate([
            'entidad' => 'required|string|max:255',
            'imagen'  => 'nullable|image|max:4096',
        ]);

        $imgPath = $this->saveImage($request->file('imagen'), null);

        $c = ProgramasConvenio::create([
            'programa_id' => $programa,
            'entidad'     => $data['entidad'],
            'imagen'      => $imgPath,
            'is_active'   => 1,
        ]);

        return response()->json(['ok' => true, 'id' => $c->id]);
    }

    /**
     * Actualizar convenio (ruta usa POST para compatibilidad con FormData).
     */
    public function update(Request $request, int $programa, int $convenio)
    {
        $c = ProgramasConvenio::where('programa_id', $programa)->findOrFail($convenio);

        $data = $request->validate([
            'entidad' => 'required|string|max:255',
            'imagen'  => 'nullable|image|max:4096',
        ]);

        $c->entidad = $data['entidad'];

        if ($request->hasFile('imagen')) {
            $c->imagen = $this->saveImage($request->file('imagen'), $c->imagen);
        }

        $c->save();

        return response()->json(['ok' => true]);
    }

    /**
     * Eliminar convenio.
     */
    public function destroy(int $programa, int $convenio)
    {
        $c = ProgramasConvenio::where('programa_id', $programa)->findOrFail($convenio);

        // Elimina archivo físico solo si está dentro de /images
        if ($c->imagen && str_starts_with($c->imagen, '/images/')) {
            $file = public_path(ltrim($c->imagen, '/'));
            if (is_file($file)) @unlink($file);
        }

        $c->delete();

        return response()->json(['ok' => true]);
    }

    /**
     * Guarda imagen en /public/images; borra la anterior si aplica.
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
