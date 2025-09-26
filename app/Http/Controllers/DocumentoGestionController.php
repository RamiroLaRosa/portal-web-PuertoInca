<?php

namespace App\Http\Controllers;

use App\Models\DocumentoGestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class DocumentoGestionController extends Controller
{
    public function index()
    {
        $items = DocumentoGestion::orderBy('id')->get();
        return view('admin.transparencia.documentos.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => ['required', 'string', 'max:200'],
            'descripcion' => ['required', 'string', 'max:2000'],
            'documento'   => ['required', 'file', 'mimes:pdf', 'max:10240'], // 10MB
            'is_active'   => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('documento')) {
            $file = $request->file('documento');

            $name = Str::uuid() . '_' .
                Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) .
                '.' .
                $file->getClientOriginalExtension();

            // mueve a public/assets
            $file->move(public_path('assets'), $name);

            // guarda ruta relativa pública
            $data['documento'] = 'assets/' . $name;
        }

        $data['is_active'] = $request->boolean('is_active');

        DocumentoGestion::create($data);

        return back()->with('success', 'Documento creado.');
    }

    public function update(Request $request, DocumentoGestion $doc)
    {
        $data = $request->validate([
            'nombre'      => ['required', 'string', 'max:200'],
            'descripcion' => ['required', 'string', 'max:2000'],
            'documento'   => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('documento')) {
            // elimina el anterior si existe
            if ($doc->documento && file_exists(public_path($doc->documento))) {
                @unlink(public_path($doc->documento));
            }

            $file = $request->file('documento');
            $name = Str::uuid() . '_' .
                Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) .
                '.' .
                $file->getClientOriginalExtension();

            $file->move(public_path('assets'), $name);
            $data['documento'] = 'assets/' . $name;
        }

        $data['is_active'] = $request->boolean('is_active');

        $doc->update($data);

        return back()->with('success', 'Documento actualizado.');
    }

    public function destroy(DocumentoGestion $doc)
    {
        if ($doc->documento && file_exists(public_path($doc->documento))) {
            @unlink(public_path($doc->documento));
        }

        $doc->delete();

        return back()->with('success', 'Documento eliminado.');
    }

    // Para usar en el iframe del modal (stream seguro del PDF)
    public function file(DocumentoGestion $documento)
    {
        abort_unless($documento->documento && Storage::exists($documento->documento), 404);
        return response()->file(Storage::path($documento->documento));
    }
}
