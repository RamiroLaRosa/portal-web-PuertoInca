<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InfoImportante;
use App\Models\MarcoLegal;
use App\Models\DerechoConsumidor;
use App\Models\TipoReclamacion;
use App\Models\TipoDocumento;
use App\Models\EstadoReclamo;
use App\Models\Reclamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage; // <— IMPORTANTE

class LibroReclamacionesController extends Controller
{
    public function index()
    {
        $info = InfoImportante::when(
            Schema::hasColumn('info_importante', 'is_active'),
            fn($q) => $q->where('is_active', 1)
        )->orderBy('id')->get();

        $tipos = TipoReclamacion::when(
            Schema::hasColumn('tipo_reclamacion', 'is_active'),
            fn($q) => $q->where('is_active', 1)
        )->orderBy('id')->get();

        $marco = MarcoLegal::when(
            Schema::hasColumn('marco_legal', 'is_active'),
            fn($q) => $q->where('is_active', 1)
        )->orderBy('id')->get();

        $derechos = DerechoConsumidor::when(
            Schema::hasColumn('derechos_consumidor', 'is_active'),
            fn($q) => $q->where('is_active', 1)
        )->orderBy('id')->get();

        $tiposDoc = TipoDocumento::when(
            Schema::hasColumn('tipo_documentos', 'is_active'),
            fn($q) => $q->where('is_active', 1)
        )->orderBy('id')->get();

        $estadoInicialId = EstadoReclamo::where('nombre', 'like', '%pendiente%')->value('id')
            ?? EstadoReclamo::min('id');

        return view('transparencia.libro_reclamaciones', compact(
            'info',
            'tipos',
            'marco',
            'derechos',
            'tiposDoc',
            'estadoInicialId'
        ));
    }

    public function store(Request $request)
    {
        $estadoInicialId = EstadoReclamo::where('nombre', 'like', '%pendiente%')->value('id')
            ?? EstadoReclamo::min('id');

        $data = $request->validate([
            'nombres'              => 'required|string|max:120',
            'apellidos'            => 'required|string|max:120',
            'tipo_documento_id'    => 'required|integer|exists:tipo_documentos,id',
            'numero_documento'     => 'required|string|max:30',
            'telefono'             => 'required|string|max:30',
            'email'                => 'required|email|max:150',
            'tipo_reclamacion_id'  => 'required|integer|exists:tipo_reclamacion,id',
            'area_relacionada'     => 'required|string|max:120',
            'fecha_incidente'      => 'nullable|date',
            'asunto'               => 'required|string|max:255',
            'descripcion'          => 'required|string|min:10',
        ]);

        $data['estado_id'] = $estadoInicialId;

        // Genera el código único LR-########
        do {
            $codigo = 'LR-' . str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
        } while (\App\Models\Reclamo::where('codigo', $codigo)->exists());
        $data['codigo'] = $codigo;

        $row = Reclamo::create($data);

        return response()->json([
            'ok' => true,
            'id' => $row->id,
            'codigo' => $row->codigo,
            'message' => 'Reclamación registrada correctamente.'
        ], 201);
    }

    // ====== ACTUALIZADO: incluye respuesta, fecha_respuesta y documento ======
    public function search(Request $request)
    {
        $data = $request->validate([
            'documento' => 'required|string|max:30',
            'codigo'    => 'required|string|max:255',
        ]);

        $rows = Reclamo::with([
            'tipoReclamacion:id,nombre',
            'estado:id,nombre'
        ])
            ->where('numero_documento', $data['documento'])
            ->where('codigo', $data['codigo'])
            ->orderByDesc('created_at')
            ->get([
                'id',
                'codigo',
                'asunto',
                'descripcion',
                'area_relacionada',
                'tipo_reclamacion_id',
                'estado_id',
                'fecha_incidente',
                'created_at',

                // ▼ campos que el modal necesita
                'respuesta',
                'fecha_respuesta',
                'documento_respuesta',
            ]);

        return response()->json([
            'ok'    => true,
            'total' => $rows->count(),
            'items' => $rows->map(function ($r) {
                $docUrl = $r->documento_respuesta
                    ? Storage::disk('public')->url($r->documento_respuesta)
                    : null;

                $verUrl = $r->documento_respuesta
                    ? route('libro.respuesta.ver', ['reclamo' => $r->id])
                    : null;

                return [
                    'id'              => $r->id,
                    'asunto'          => $r->asunto,
                    'descripcion'     => $r->descripcion,
                    'area'            => $r->area_relacionada,
                    'tipo'            => optional($r->tipoReclamacion)->nombre,
                    'estado'          => optional($r->estado)->nombre,
                    'fecha'           => optional($r->created_at)->format('Y-m-d'),
                    'fecha_inc'       => optional($r->fecha_incidente)->format('Y-m-d'),

                    // ▼ mostrado en el modal
                    'respuesta'       => $r->respuesta,
                    'fecha_respuesta' => $r->fecha_respuesta ? (string)$r->fecha_respuesta : null,
                    'documento_url'   => $docUrl,   // /storage/...
                    'documento_ver_url' => $verUrl,  // ruta inline opcional
                ];
            }),
        ]);
    }

    // ====== NUEVO: ver el documento inline (PDF/imagen) ======
    public function verDocumento(Reclamo $reclamo)
    {
        if (!$reclamo->documento_respuesta) {
            abort(404);
        }

        $disk = Storage::disk('public');
        $path = $reclamo->documento_respuesta;

        if (!$disk->exists($path)) {
            abort(404);
        }

        $absolutePath = $disk->path($path);
        $mime = mime_content_type($absolutePath) ?: 'application/octet-stream';

        return response()->file($absolutePath, [
            'Content-Type'        => $mime,
            'Content-Disposition' => 'inline; filename="' . basename($absolutePath) . '"',
            'Cache-Control'       => 'private, max-age=0, no-cache',
        ]);
    }
}
