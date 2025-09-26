<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfoImportante;
use Illuminate\Http\Request;

class InfoImportanteController extends Controller
{
    public function index()
    {
        // Solo devuelve la vista; la tabla se llena por AJAX
        return view('admin.transparencia.libro_reclamaciones.informacion_importante.index');
    }

    public function list()
    {
        $data = InfoImportante::orderBy('id')->get();
        return response()->json($data);
    }

    public function show($id)
    {
        $row = InfoImportante::findOrFail($id);
        return response()->json($row);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
        ]);

        $row = InfoImportante::create($validated);
        return response()->json(['ok' => true, 'id' => $row->id]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
        ]);

        $row = InfoImportante::findOrFail($id);
        $row->update($validated);

        return response()->json(['ok' => true]);
    }

    public function destroy($id)
    {
        $row = InfoImportante::findOrFail($id);
        $row->delete();

        return response()->json(['ok' => true]);
    }
}
