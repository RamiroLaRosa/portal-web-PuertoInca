<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DerechoConsumidor;
use Illuminate\Http\Request;

class DerechosController extends Controller
{
    public function index()
    {
        return view('admin.transparencia.libro_reclamaciones.derechos.index');
    }

    // Listado JSON para la tabla
    public function grid()
    {
        return response()->json(
            DerechoConsumidor::orderBy('id')->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'required|string|max:2000',
            'icono'       => 'required|string|max:100', // ej. "fa-solid fa-user-shield"
            'is_active'   => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');

        $row = DerechoConsumidor::create($data);
        return response()->json(['ok' => true, 'id' => $row->id], 201);
    }

    public function update(Request $request, DerechoConsumidor $derecho)
    {
        $data = $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'required|string|max:2000',
            'icono'       => 'required|string|max:100',
            'is_active'   => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');

        $derecho->update($data);
        return response()->json(['ok' => true]);
    }

    public function destroy(DerechoConsumidor $derecho)
    {
        $derecho->delete();
        return response()->json(['ok' => true]);
    }
}
