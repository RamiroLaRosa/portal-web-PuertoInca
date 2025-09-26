<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProgramasAreaController extends Controller
{
    /** Ruta por defecto cuando no hay imagen */
    private string $noPhoto = '/images/no-photo.jpg';

    /** Construye una URL absoluta para la imagen (o no-photo) */
    private function buildImageUrl(?string $path): string
    {
        $p = $path && trim($path) !== '' ? $path : $this->noPhoto;
        // Asegurar que empiece con /images/...
        if (!Str::startsWith($p, ['/images/', 'http://', 'https://'])) {
            $p = '/images/' . ltrim($p, '/');
        }
        return asset(ltrim($p, '/'));
    }

    /** Guarda el archivo en /public/images y devuelve '/images/archivo.ext' */
    private function saveImage(?\Illuminate\Http\UploadedFile $file): ?string
    {
        if (!$file) return null;

        $ext  = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $name = 'area_' . now()->format('Ymd_His') . '_' . Str::random(6) . '.' . $ext;

        $dest = public_path('images');
        if (!is_dir($dest)) {
            @mkdir($dest, 0775, true);
        }
        $file->move($dest, $name);

        // Guardamos como ruta relativa desde public
        return '/images/' . $name;
    }

    /** Lista de áreas por programa (GET /{programa}/areas) */
    public function index(int $programa)
    {
        $rows = DB::table('programa_areas')
            ->where('programa_id', $programa)
            ->orderBy('id')
            ->get();

        $areas = $rows->map(function ($r) {
            return [
                'id'          => (int) $r->id,
                'programa_id' => (int) $r->programa_id,
                'nombre'      => (string) $r->nombre,
                'descripcion' => (string) ($r->descripcion ?? ''),
                'imagen'      => (string) ($r->imagen ?? ''),
                'imagen_url'  => $this->buildImageUrl($r->imagen),
            ];
        });

        return response()->json([
            'ok'    => true,
            'areas' => $areas,
        ]);
    }

    /** Crear área (POST /{programa}/areas) */
    public function store(Request $request, int $programa)
    {
        $data = $request->validate([
            'nombre'      => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'imagen'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ], [], [
            'nombre'      => 'nombre',
            'descripcion' => 'descripción',
            'imagen'      => 'imagen',
        ]);

        $imgPath = $this->saveImage($request->file('imagen'));

        $id = DB::table('programa_areas')->insertGetId([
            'programa_id' => $programa,
            'nombre'      => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? null,
            'imagen'      => $imgPath ?: null,
            'is_active'   => 1,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        $row = DB::table('programa_areas')->where('id', $id)->first();

        return response()->json([
            'ok'   => true,
            'area' => [
                'id'          => (int) $row->id,
                'programa_id' => (int) $row->programa_id,
                'nombre'      => (string) $row->nombre,
                'descripcion' => (string) ($row->descripcion ?? ''),
                'imagen'      => (string) ($row->imagen ?? ''),
                'imagen_url'  => $this->buildImageUrl($row->imagen),
            ],
            'msg'  => 'Área creada correctamente',
        ], 201);
    }

    /** Obtener un área (GET /{programa}/areas/{area}) */
    public function show(int $programa, int $area)
    {
        $row = DB::table('programa_areas')
            ->where('id', $area)
            ->where('programa_id', $programa)
            ->first();

        if (!$row) {
            return response()->json(['ok' => false, 'msg' => 'Área no encontrada'], 404);
        }

        return response()->json([
            'ok'   => true,
            'area' => [
                'id'          => (int) $row->id,
                'programa_id' => (int) $row->programa_id,
                'nombre'      => (string) $row->nombre,
                'descripcion' => (string) ($row->descripcion ?? ''),
                'imagen'      => (string) ($row->imagen ?? ''),
                'imagen_url'  => $this->buildImageUrl($row->imagen),
            ],
        ]);
    }

    /** Actualizar un área (PUT /{programa}/areas/{area}) */
    public function update(Request $request, int $programa, int $area)
    {
        $row = DB::table('programa_areas')
            ->where('id', $area)
            ->where('programa_id', $programa)
            ->first();

        if (!$row) {
            return response()->json(['ok' => false, 'msg' => 'Área no encontrada'], 404);
        }

        $data = $request->validate([
            'nombre'      => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'imagen'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $update = [
            'nombre'      => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? null,
            'updated_at'  => now(),
        ];

        if ($request->hasFile('imagen')) {
            $newPath = $this->saveImage($request->file('imagen'));
            if ($newPath) {
                $update['imagen'] = $newPath;
            }
        }

        DB::table('programa_areas')
            ->where('id', $area)
            ->update($update);

        $refreshed = DB::table('programa_areas')->where('id', $area)->first();

        return response()->json([
            'ok'   => true,
            'area' => [
                'id'          => (int) $refreshed->id,
                'programa_id' => (int) $refreshed->programa_id,
                'nombre'      => (string) $refreshed->nombre,
                'descripcion' => (string) ($refreshed->descripcion ?? ''),
                'imagen'      => (string) ($refreshed->imagen ?? ''),
                'imagen_url'  => $this->buildImageUrl($refreshed->imagen),
            ],
            'msg'  => 'Área actualizada correctamente',
        ]);
    }

    /** Eliminar un área (DELETE /{programa}/areas/{area}) */
    public function destroy(int $programa, int $area)
    {
        $row = DB::table('programa_areas')
            ->where('id', $area)
            ->where('programa_id', $programa)
            ->first();

        if (!$row) {
            return response()->json(['ok' => false, 'msg' => 'Área no encontrada'], 404);
        }

        DB::table('programa_areas')->where('id', $area)->delete();

        // Si quisieras borrar el archivo físico, descomenta:
        // if ($row->imagen && Str::startsWith($row->imagen, '/images/')) {
        //     @unlink(public_path(ltrim($row->imagen, '/')));
        // }

        return response()->json([
            'ok'  => true,
            'msg' => 'Área eliminada correctamente',
        ]);
    }
}
