<?php

namespace App\Http\Controllers;

use App\Models\MatriculaRequisito;
use Illuminate\Http\Request;

class MatriculaRequisitoController extends Controller
{
    /** Opciones para el combobox de íconos (label => value) */
    private array $iconOptions = [
        'Archivo'              => 'fa-solid fa-file',
        'Lista con checks'     => 'fa-solid fa-list-check',
        'Lista'                => 'fa-solid fa-list',
        'Tarjeta'              => 'fa-solid fa-id-card',
        'Carpeta'              => 'fa-solid fa-folder',
        'Documento firmado'    => 'fa-solid fa-file-signature',
        'Subir archivo'        => 'fa-solid fa-upload',
        'Descargar'            => 'fa-solid fa-download',
        'Calendario'           => 'fa-solid fa-calendar',
        'Estrella'             => 'fa-solid fa-star',
        'Check'                => 'fa-solid fa-check',
    ];

    public function index()
    {
        $items       = MatriculaRequisito::orderBy('id', 'asc')->get();
        $iconOptions = $this->iconOptions;

        return view('admin.admision_matricula.matricula.requisitos.index', compact('items', 'iconOptions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'    => ['required', 'string', 'max:150'],
            'icono'     => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        MatriculaRequisito::create([
            'titulo'    => $data['titulo'],
            'icono'     => $data['icono'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('matri-requisitos.index')->with('success', 'Registro creado.');
    }

    public function update(Request $request, MatriculaRequisito $req)
    {
        $data = $request->validate([
            'titulo'    => ['required', 'string', 'max:150'],
            'icono'     => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $req->update([
            'titulo'    => $data['titulo'],
            'icono'     => $data['icono'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('matri-requisitos.index')->with('success', 'Registro actualizado.');
    }

    public function destroy(MatriculaRequisito $req)
    {
        $req->delete(); // Soft delete
        // Si quieres hard delete: $req->forceDelete();
        return redirect()->route('matri-requisitos.index')->with('success', 'Registro eliminado.');
    }
}
