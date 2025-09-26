<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramasEstudio;
use App\Models\ProgramasCoordinador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProgramasCoordinadorController extends Controller
{
    // GET: lista coordinadores por programa
    public function index($programaId)
    {
        $programa = ProgramasEstudio::findOrFail($programaId);

        $coordinadores = ProgramasCoordinador::where('programa_id', $programa->id)
            ->where('is_active', 1)
            ->orderBy('id')
            ->get()
            ->map(function ($c) {
                // La BD guarda "./images/archivo.jpg" -> convertirlo a URL pública
                $fotoRel = $c->foto ?: './images/no-photo.jpg';
                // asset() no quiere "./" al inicio
                $fotoUrl = asset(ltrim($fotoRel, './'));

                return [
                    'id'        => $c->id,
                    'nombres'   => $c->nombres,
                    'apellidos' => $c->apellidos,
                    'cargo'     => $c->cargo,
                    'palabras'  => $c->palabras,
                    'foto_url'  => $fotoUrl,
                ];
            })->values();

        return response()->json([
            'programa'      => ['id' => $programa->id, 'nombre' => $programa->nombre],
            'coordinadores' => $coordinadores,
        ]);
    }

    // POST: crear/actualizar/eliminar coordinadores del programa
    public function sync(Request $request, $programaId)
    {
        $programa = ProgramasEstudio::findOrFail($programaId);

        $request->validate([
            'coordinadores'                => ['required','array'],
            'coordinadores.*.id'           => ['nullable','integer','min:1'],
            'coordinadores.*.nombres'      => ['required','string','max:150'],
            'coordinadores.*.apellidos'    => ['nullable','string','max:150'],
            'coordinadores.*.cargo'        => ['nullable','string','max:150'],
            'coordinadores.*.mensaje'      => ['nullable','string','max:2000'],
            'coordinadores.*.foto'         => ['nullable','file','image','max:4096'],
        ]);

        $payload = $request->input('coordinadores', []);
        $keepIds = [];

        foreach ($payload as $idx => $item) {
            $id        = $item['id'] ?? null;
            $nombres   = $item['nombres'] ?? '';
            $apellidos = $item['apellidos'] ?? null;
            $cargo     = $item['cargo'] ?? null;
            $mensaje   = $item['mensaje'] ?? null;

            if ($id) {
                $model = ProgramasCoordinador::where('programa_id', $programa->id)->findOrFail($id);
            } else {
                $model = new ProgramasCoordinador();
                $model->programa_id = $programa->id;
            }

            $model->nombres   = $nombres;
            $model->apellidos = $apellidos;
            $model->cargo     = $cargo;
            $model->palabras  = $mensaje;
            $model->is_active = 1;

            // ====== Guardar foto en public/images (ruta en BD: ./images/archivo.jpg) ======
            $fileKey = "coordinadores.$idx.foto";
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);

                // Asegura que exista public/images
                $dest = public_path('images');
                if (!File::isDirectory($dest)) {
                    File::makeDirectory($dest, 0755, true);
                }

                // Nombre único
                $filename = 'coord_' . now()->format('Ymd_His') . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();

                // Si tenía una foto anterior dentro de ./images, puedes borrar (opcional)
                if (!empty($model->foto)) {
                    $prev = public_path(ltrim($model->foto, './')); // ./images/xxx -> public/images/xxx
                    if (File::exists($prev) && Str::startsWith($model->foto, ['./images/', '/images/'])) {
                        // Evitar borrar no-photo.jpg
                        if (!Str::endsWith($model->foto, 'no-photo.jpg')) {
                            @File::delete($prev);
                        }
                    }
                }

                // Mover archivo
                $file->move($dest, $filename);

                // Guardar en BD con el formato solicitado
                $model->foto = './images/' . $filename;
            }

            $model->save();
            $keepIds[] = $model->id;
        }

        // Eliminar los que ya no vienen (soft delete o delete real según tu modelo)
        ProgramasCoordinador::where('programa_id', $programa->id)
            ->whereNotIn('id', $keepIds)
            ->delete();

        // Respuesta refrescada
        $refreshed = ProgramasCoordinador::where('programa_id', $programa->id)
            ->where('is_active', 1)
            ->orderBy('id')
            ->get()
            ->map(function ($c) {
                $fotoRel = $c->foto ?: './images/no-photo.jpg';
                $fotoUrl = asset(ltrim($fotoRel, './'));
                return [
                    'id'        => $c->id,
                    'nombres'   => $c->nombres,
                    'apellidos' => $c->apellidos,
                    'cargo'     => $c->cargo,
                    'palabras'  => $c->palabras,
                    'foto_url'  => $fotoUrl,
                ];
            })->values();

        return response()->json([
            'ok'            => true,
            'coordinadores' => $refreshed,
        ]);
    }
}
