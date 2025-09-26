<?php

namespace App\Http\Controllers;

use App\Models\DocumentoGestion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DocumentoPublicController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string)$request->get('q', ''));

        $documentos = DocumentoGestion::query()
            ->where('is_active', true)
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('nombre', 'like', "%{$q}%")
                        ->orWhere('descripcion', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(9)          // 3x3 por página; ajusta a gusto
            ->withQueryString();   // conserva ?q= en la paginación

        return view('transparencia.documentos', [
            'documentos' => $documentos,
            'q' => $q,
        ]);
    }


    public function file(DocumentoGestion $documento)
    {
        $path = trim((string) $documento->documento);
        abort_unless($path !== '', 404);

        // 1) Si es URL absoluta
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return redirect()->away($path);
        }

        // Normaliza "/assets/xxx.pdf" -> "assets/xxx.pdf"
        $relative = ltrim($path, '/');

        // 2) ¿Existe en public/ (p. ej. public/assets/xxx.pdf)?
        $absPublic = public_path($relative);
        if (is_file($absPublic)) {
            return response()->file($absPublic, [
                'Content-Type'  => 'application/pdf',
                'Cache-Control' => 'private, max-age=10800',
            ]);
        }

        // 3) ¿Existe en storage/app/public?
        //    (quitamos un posible prefijo "public/" y probamos con el disco 'public')
        $relForDisk = ltrim(preg_replace('#^public/#', '', $relative), '/');
        if (Storage::disk('public')->exists($relForDisk)) {
            $abs = storage_path('app/public/' . $relForDisk);
            return response()->file($abs, [
                'Content-Type'  => 'application/pdf',
                'Cache-Control' => 'private, max-age=10800',
            ]);
        }

        // 4) ¿Existe en storage/app en general?
        if (Storage::exists($relative)) {
            $abs = storage_path('app/' . $relative);
            return response()->file($abs, [
                'Content-Type'  => 'application/pdf',
                'Cache-Control' => 'private, max-age=10800',
            ]);
        }

        // 5) Último intento: redirige a la URL pública por si el servidor sirve esa ruta
        return redirect()->to(url($relative));
    }
}
