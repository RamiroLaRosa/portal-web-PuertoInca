<?php

// app/Http/Controllers/OrganigramaController.php
namespace App\Http\Controllers;

use App\Models\Organigrama;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrganigramaController extends Controller
{
    public function index()
    {
        $row = Organigrama::first(); // tu tabla tiene 1 registro
        // $row->documento guarda algo como "/assets/Organigrama.pdf"
        $documentUrl = $row ? asset(ltrim($row->documento, '/')) : null;

        return view('admin.nosotros.organigrama.index', compact('documentUrl'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'documento' => ['required', 'file', 'mimes:pdf', 'max:20480'], // 20 MB
        ], [
            'documento.required' => 'Selecciona un PDF.',
            'documento.mimes'    => 'El archivo debe ser un PDF.',
            'documento.max'      => 'El PDF no puede superar 20MB.',
        ]);

        $file = $request->file('documento');

        // Nombre final (puedes mantener Organigrama.pdf si quieres sobreescribir siempre)
        // $filename = 'Organigrama.pdf';
        $filename = 'Organigrama_' . Str::random(6) . '.pdf';

        // Guardar físicamente en public/assets
        $file->move(public_path('assets'), $filename);

        $path = '/assets/' . $filename;

        // Actualizar o crear registro único
        $row = Organigrama::first();
        if ($row) {
            // Si quieres, limpia el archivo anterior:
            if (!empty($row->documento)) {
                $old = public_path(ltrim($row->documento, '/'));
                if (is_file($old)) @unlink($old);
            }
            $row->update([
                'documento' => $path,
                'is_active' => 1,
            ]);
        } else {
            Organigrama::create([
                'documento' => $path,
                'is_active' => 1,
            ]);
        }

        return redirect()
            ->route('organigrama.index')
            ->with('success', 'Organigrama actualizado correctamente.');
    }

    public function showPublic()
    {
        $row = Organigrama::where('is_active', 1)->latest('updated_at')->first();

        $documentUrl = $row
            ? asset(ltrim($row->documento, '/')) . '?v=' . optional($row->updated_at)->timestamp
            : null;

        return view('nosotros.organigrama', compact('documentUrl', 'row'));
    }
}
