<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoReclamacion;
use Illuminate\Http\Request;

class TipoReclamacionController extends Controller
{
    public function index()
    {
        return view('admin.transparencia.libro_reclamaciones.tipo_reclamacion.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
        ]);

        $row = TipoReclamacion::create($data);
        return response()->json(['ok' => true, 'id' => $row->id], 201);
    }

    public function update(Request $request, TipoReclamacion $tipoReclamacion)
    {
        $data = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
        ]);

        $tipoReclamacion->update($data);
        return response()->json(['ok' => true]);
    }

    public function destroy(TipoReclamacion $tipoReclamacion)
    {
        $tipoReclamacion->delete();
        return response()->json(['ok' => true]);
    }

    /** Endpoint para listado en JSON (AJAX) */
    public function grid()
    {
        return response()->json(TipoReclamacion::orderBy('id')->get());
    }
}
