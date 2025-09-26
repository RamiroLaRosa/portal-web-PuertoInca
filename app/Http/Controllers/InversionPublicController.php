<?php
// app/Http/Controllers/InversionPublicController.php

namespace App\Http\Controllers;

use App\Models\Inversion;
use Illuminate\Support\Facades\Storage;

class InversionPublicController extends Controller
{
    public function index()
    {
        // Trae solo activos y con su tipo
        $items = Inversion::where('is_active', true)
            ->with('tipo')
            ->orderBy('id')
            ->get();

        // Agrupa por tipo (IDs: 1=Inversiones/Reinversiones, 2=Obras, 3=Donaciones)
        $groups = [
            1 => $items->where('tipo_inversion_id', 1)->values(),
            2 => $items->where('tipo_inversion_id', 2)->values(),
            3 => $items->where('tipo_inversion_id', 3)->values(),
        ];

        return view('transparencia.inversiones', compact('groups'));
    }

    // Abre/stream del PDF en pestaña nueva
    public function file(Inversion $inversion)
    {
        $raw = $inversion->documento;
        abort_unless($raw, 404);

        // Si es URL absoluta -> redirige fuera
        if (preg_match('#^https?://#i', $raw)) {
            return redirect()->away($raw);
        }

        // Normaliza rutas guardadas como "/assets/..", "assets/..", "./assets/.."
        $path = ltrim($raw, '/');
        $path = ltrim($path, './');    // quita un posible "./" inicial

        // 1) Archivo en public/
        $public = public_path($path);
        if (is_file($public)) {
            return response()->file($public, [
                'Content-Type'  => 'application/pdf',
                'Cache-Control' => 'private, max-age=10800',
            ]);
        }

        // 2) Archivo en storage (si lo hubieras guardado allí)
        if (Storage::exists($path)) {
            return response()->file(Storage::path($path), [
                'Content-Type'  => 'application/pdf',
                'Cache-Control' => 'private, max-age=10800',
            ]);
        }

        abort(404);
    }
}
