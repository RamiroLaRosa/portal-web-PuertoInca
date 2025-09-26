<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class NoticiaController extends Controller
{
    public function index()
    {
        $items = Noticia::orderBy('id', 'asc')->get();
        return view('admin.noticias.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'      => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'fecha'       => ['required', 'date'],
            'imagen'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'documento'   => ['nullable', 'mimes:pdf', 'max:20480'], // hasta 20MB
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        // === Imagen -> /public/images ===
        if ($request->hasFile('imagen')) {
            $fn = 'NOT_IMG_' . Str::upper(Str::random(10)) . '_' . time() . '.' .
                $request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move(public_path('images'), $fn);
            // guardamos sin slash inicial para evitar dobles //
            $data['imagen'] = 'images/' . $fn;
        }

        // === Documento PDF -> /public/assets ===
        if ($request->hasFile('documento')) {
            $pdf = $request->file('documento');
            $pdfName = 'NOT_DOC_' . Str::upper(Str::random(10)) . '_' . time() . '.' . $pdf->getClientOriginalExtension();
            $pdf->move(public_path('assets'), $pdfName);
            // puedes guardar con o sin slash inicial; tu Blade ya tolera ambos
            $data['documento'] = '/assets/' . $pdfName;
        }

        Noticia::create($data);

        return back()->with('success', 'Noticia registrada correctamente.');
    }

    public function update(Request $request, Noticia $noticia)
    {
        $data = $request->validate([
            'titulo'      => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'fecha'       => ['required', 'date'],
            'imagen'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'documento'   => ['nullable', 'mimes:pdf', 'max:20480'], // hasta 20MB
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        // === Reemplazar imagen (si llega) ===
        if ($request->hasFile('imagen')) {
            if ($noticia->imagen && File::exists(public_path($noticia->imagen))) {
                @File::delete(public_path($noticia->imagen));
            }
            $fn = 'NOT_IMG_' . Str::upper(Str::random(10)) . '_' . time() . '.' .
                $request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move(public_path('images'), $fn);
            $data['imagen'] = 'images/' . $fn;
        }

        // === Reemplazar documento PDF (si llega) ===
        if ($request->hasFile('documento')) {
            // borra el anterior si existe
            if ($noticia->documento && File::exists(public_path(ltrim($noticia->documento, '/')))) {
                @File::delete(public_path(ltrim($noticia->documento, '/')));
            }
            $pdf = $request->file('documento');
            $pdfName = 'NOT_DOC_' . Str::upper(Str::random(10)) . '_' . time() . '.' . $pdf->getClientOriginalExtension();
            $pdf->move(public_path('assets'), $pdfName);
            $data['documento'] = '/assets/' . $pdfName;
        }

        $noticia->update($data);

        return back()->with('success', 'Noticia actualizada.');
    }

    public function destroy(Noticia $noticia)
    {
        // elimina imagen física
        if ($noticia->imagen && File::exists(public_path($noticia->imagen))) {
            @File::delete(public_path($noticia->imagen));
        }
        $noticia->delete();

        return back()->with('success', 'Noticia eliminada.');
    }

    public function publicIndex()
    {
        // Solo activas, ordenadas por fecha DESC (y luego id)
        $news = Noticia::where('is_active', true)
            ->orderBy('fecha', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $featured = $news->first();
        $others   = $news->slice(1); // el resto

        return view('otros.noticias', compact('featured', 'others'));
    }

    /** Página pública - detalle simple */
    public function show(\App\Models\Noticia $noticia)
    {
        abort_unless($noticia->is_active, 404);

        $others = \App\Models\Noticia::where('is_active', true)
            ->where('id', '!=', $noticia->id)
            ->orderBy('fecha', 'desc')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        // <- usar la nueva vista
        return view('otros.lectura_noticias', compact('noticia', 'others'));
    }
}
