<?php

// app/Http/Controllers/PresentacionController.php
namespace App\Http\Controllers;

use App\Models\Presentacion;
use App\Models\Resenia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PresentacionController extends Controller
{
    public function index()
    {
        // Usamos el primer registro. Si no existe, lo creamos con valores por defecto.
        $presentacion = Presentacion::first();

        if (!$presentacion) {
            $presentacion = Presentacion::create([
                'titulo'            => 'Palabras del director',
                'nombre_director'   => 'Dr. Juan Pérez',
                'palabras_director' => '',
                'foto_director'     => 'images/no-photo.jpg',
                'is_active'         => true,
            ]);
        }

        return view('admin.nosotros.presentacion.index', compact('presentacion'));
    }

    public function update(Request $request, $id)
    {
        $presentacion = Presentacion::findOrFail($id);

        // 1) Validación
        $data = $request->validate([
            'titulo'            => ['required', 'string', 'max:150'],
            'nombre_director'   => ['required', 'string', 'max:150'],
            'palabras_director' => ['nullable', 'string'],
            'foto_director'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_active'         => ['nullable', 'boolean'],
        ]);

        // 2) Campos directos
        $presentacion->titulo = $data['titulo'];
        $presentacion->nombre_director = $data['nombre_director'];
        $presentacion->is_active = $request->boolean('is_active');

        // 3) Normalizar el texto (sin HTML) y con acentos correctos
        //    - Decodifica entidades (&oacute; -> ó)
        //    - Elimina etiquetas (<p>, <br>, etc.)
        //    - Normaliza saltos de línea a "\n"
        $raw      = $data['palabras_director'] ?? '';
        $decoded  = html_entity_decode($raw, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $stripped = strip_tags($decoded);
        $plain    = preg_replace("/\r\n?/", "\n", $stripped);
        $presentacion->palabras_director = $plain;

        // 4) Manejo de imagen (si se sube una nueva)
        if ($request->hasFile('foto_director')) {
            $dir = 'images/institucion/director'; // public/images/institucion/director
            if (!is_dir(public_path($dir))) {
                @mkdir(public_path($dir), 0775, true);
            }

            $file = $request->file('foto_director');
            $filename = time() . '_' . \Illuminate\Support\Str::slug(substr($presentacion->nombre_director, 0, 40)) . '.' . $file->extension();
            $file->move(public_path($dir), $filename);

            // Borrar la anterior si existe y no es la genérica
            $prev = ltrim($presentacion->getOriginal('foto_director') ?? '', './');
            if ($prev && $prev !== 'images/no-photo.jpg' && file_exists(public_path($prev))) {
                @unlink(public_path($prev));
            }

            $presentacion->foto_director = $dir . '/' . $filename;
        }

        // 5) Guardar cambios
        $presentacion->save();

        return redirect()
            ->route('presentacion.index')
            ->with('success', 'Presentación actualizada correctamente.');
    }


    public function showPublic()
    {
        $presentacion = Presentacion::where('is_active', true)
            ->latest('updated_at')
            ->first() ?? Presentacion::first();

        // SOLO reseñas activas, en orden de aparición
        $resenias = Resenia::where('is_active', true)
            ->orderBy('id')
            ->get();

        return view('nosotros.presentacion', compact('presentacion', 'resenias'));
    }
}
