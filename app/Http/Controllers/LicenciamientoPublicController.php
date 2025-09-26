<?php

namespace App\Http\Controllers;

use App\Models\Licenciamiento;
use Illuminate\Support\Facades\Storage;

class LicenciamientoPublicController extends Controller
{
    // Página pública: usa el primero activo
    public function index()
    {
        $lic = Licenciamiento::where('is_active', true)
            ->orderBy('id')
            ->first();

        return view('transparencia.licenciamiento', compact('lic'));
    }

    // Stream/descarga del PDF
    public function file(Licenciamiento $licenciamiento)
    {
        $path = $licenciamiento->documento;
        abort_unless($path, 404);

        // Normaliza por si viene con "/" inicial
        $relative = ltrim($path, '/');

        // 1) si está en public/
        $publicFile = public_path($relative);
        if (file_exists($publicFile)) {
            return response()->file($publicFile, [
                'Content-Type'  => 'application/pdf',
                'Cache-Control' => 'private, max-age=10800',
            ]);
        }

        // 2) si estuviera en storage
        if (Storage::exists($relative)) {
            return response()->file(Storage::path($relative), [
                'Content-Type'  => 'application/pdf',
                'Cache-Control' => 'private, max-age=10800',
            ]);
        }

        abort(404);
    }
}
