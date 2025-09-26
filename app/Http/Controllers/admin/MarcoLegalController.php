<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarcoLegal;
use Illuminate\Http\Request;

class MarcoLegalController extends Controller
{
    public function index()
    {
        return view('admin.transparencia.libro_reclamaciones.marco_legal.index');
    }

    // Listado para AJAX
    public function grid()
    {
        return response()->json(
            MarcoLegal::orderBy('id')->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'required|string|max:2000',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $row = MarcoLegal::create($data);
        return response()->json(['ok' => true, 'id' => $row->id], 201);
    }

    public function update(Request $request, MarcoLegal $marcoLegal)
    {
        $data = $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'required|string|max:2000',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $marcoLegal->update($data);
        return response()->json(['ok' => true]);
    }

    public function destroy(MarcoLegal $marcoLegal)
    {
        $marcoLegal->delete();
        return response()->json(['ok' => true]);
    }
}
