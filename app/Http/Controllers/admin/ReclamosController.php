<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reclamo;
use App\Models\TipoReclamacion;
use App\Models\EstadoReclamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class ReclamosController extends Controller
{
    public function index()
    {
        return view('admin.transparencia.libro_reclamaciones.reclamos.index');
    }

    public function grid(Request $request)
    {
        $q = Reclamo::with(['tipoDocumento', 'tipoReclamacion', 'estado'])->orderBy('id');

        if ($request->filled('tipo_reclamacion_id')) {
            $q->where('tipo_reclamacion_id', $request->integer('tipo_reclamacion_id'));
        }
        if ($s = trim($request->get('search', ''))) {
            $q->where(function ($qq) use ($s) {
                $qq->where('nombres', 'like', "%$s%")
                    ->orWhere('apellidos', 'like', "%$s%")
                    ->orWhere('numero_documento', 'like', "%$s%")
                    ->orWhere('email', 'like', "%$s%")
                    ->orWhere('asunto', 'like', "%$s%");
            });
        }
        return response()->json($q->get());
    }

    public function tipos()
    {
        return response()->json(TipoReclamacion::orderBy('id')->get(['id', 'nombre']));
    }

    public function estados()
    {
        return response()->json(EstadoReclamo::orderBy('id')->get(['id', 'nombre']));
    }

    public function actualizarEstado(Request $request, Reclamo $reclamo)
    {
        // Toma el nombre real de la tabla desde el modelo (singular/plural no importa)
        $table = (new EstadoReclamo)->getTable();

        $data = $request->validate([
            'estado_id' => ['required', 'integer', Rule::exists($table, 'id')],
        ]);

        $reclamo->update(['estado_id' => (int) $data['estado_id']]);

        $estado = EstadoReclamo::find($data['estado_id']);

        return response()->json([
            'ok'            => true,
            'reclamo_id'    => $reclamo->id,
            'estado_id'     => (int) $data['estado_id'],
            'estado_nombre' => $estado?->nombre,
        ]);
    }

    /** ------- RESPUESTA: Crear ------- */
    public function storeRespuesta(Request $request, Reclamo $reclamo)
    {
        $data = $request->validate([
            'respuesta'       => 'required|string',
            'fecha_respuesta' => 'nullable|date',
            'documento'       => 'nullable|file|max:10240', // 10MB
        ]);

        // Mantener el path anterior si existe
        $path = $reclamo->documento_respuesta;

        // Si suben un nuevo archivo, eliminamos el anterior y guardamos el nuevo
        if ($request->hasFile('documento')) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $path = $request->file('documento')->store('reclamos', 'public');
        }

        // Guardar cambios
        $reclamo->update([
            'respuesta'           => $data['respuesta'],
            'fecha_respuesta'     => $data['fecha_respuesta'] ?? null,
            'documento_respuesta' => $path,
        ]);

        $reclamo->refresh();

        return response()->json([
            'ok'            => true,
            'reclamo'       => $reclamo->toArray(),              // incluye appends si los definiste
            'documento_url' => $reclamo->documento_url ?? null,  // opcional
        ], 200, ['Content-Type' => 'application/json; charset=utf-8']);
    }

    /** ------- RESPUESTA: Editar ------- */
    public function updateRespuesta(Request $request, Reclamo $reclamo)
    {
        $data = $request->validate([
            'respuesta'       => 'required|string',
            'fecha_respuesta' => 'nullable|date',
            'documento'       => 'nullable|file|max:10240',
        ]);

        $path = $reclamo->documento_respuesta;

        if ($request->hasFile('documento')) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $path = $request->file('documento')->store('reclamos', 'public');
        }

        $reclamo->update([
            'respuesta'           => $data['respuesta'],
            'fecha_respuesta'     => $data['fecha_respuesta'] ?? null,
            'documento_respuesta' => $path,
        ]);

        $reclamo->refresh();

        return response()->json([
            'ok'            => true,
            'reclamo'       => $reclamo->toArray(),
            'documento_url' => $reclamo->documento_url ?? null,
        ], 200, ['Content-Type' => 'application/json; charset=utf-8']);
    }

    /** ------- RESPUESTA: Eliminar ------- */
    public function destroyRespuesta(Request $request, Reclamo $reclamo)
    {
        if ($reclamo->documento_respuesta && Storage::disk('public')->exists($reclamo->documento_respuesta)) {
            Storage::disk('public')->delete($reclamo->documento_respuesta);
        }

        $reclamo->update([
            'respuesta'           => null,
            'documento_respuesta' => null,
            'fecha_respuesta'     => null,
        ]);

        $reclamo->refresh();

        return response()->json([
            'ok'      => true,
            'reclamo' => $reclamo->toArray(),
        ], 200, ['Content-Type' => 'application/json; charset=utf-8']);
    }

    /** ------- VER documento inline ------- */
    public function verRespuesta(Reclamo $reclamo)
    {
        if (!$reclamo->documento_respuesta) {
            abort(404);
        }

        $disk = Storage::disk('public');
        $path = $reclamo->documento_respuesta;

        if (!$disk->exists($path)) {
            abort(404);
        }

        // Ruta absoluta (sin usar métodos que manchen el intellisense)
        $absolutePath = storage_path('app/public/' . $path);
        $mime = File::mimeType($absolutePath) ?? 'application/pdf';

        return response()->file($absolutePath, [
            'Content-Type'        => $mime,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
            'Cache-Control'       => 'private, max-age=0, no-cache',
        ]);
    }
}
