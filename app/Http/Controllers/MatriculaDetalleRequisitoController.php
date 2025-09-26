<?php

namespace App\Http\Controllers;

use App\Models\MatriculaDetalleRequisito;
use App\Models\MatriculaRequisito;
use Illuminate\Http\Request;

class MatriculaDetalleRequisitoController extends Controller
{
    public function index()
    {
        // Listado (ascendente por ID) + relación para mostrar título e icono
        $items = MatriculaDetalleRequisito::with('requisito')
            ->orderBy('id', 'asc')
            ->get();

        // Para el combobox de cabecera
        $requisitos = MatriculaRequisito::activos()
            ->orderBy('titulo')
            ->get(['id','titulo','icono']);

        return view('admin.admision_matricula.matricula.detalle-requisitos.index', compact('items','requisitos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'matricula_requisitos_id' => ['required','integer','exists:matricula_requisitos,id'],
            'descripcion'             => ['required','string','max:1000'],
            'is_active'               => ['nullable','boolean'],
        ]);

        MatriculaDetalleRequisito::create([
            'matricula_requisitos_id' => $data['matricula_requisitos_id'],
            'descripcion'             => $data['descripcion'],
            'is_active'               => $request->boolean('is_active'),
        ]);

        return redirect()->route('matri-detalle-requisitos.index')->with('success', 'Registro creado.');
    }

    public function update(Request $request, MatriculaDetalleRequisito $detalle)
    {
        $data = $request->validate([
            'matricula_requisitos_id' => ['required','integer','exists:matricula_requisitos,id'],
            'descripcion'             => ['required','string','max:1000'],
            'is_active'               => ['nullable','boolean'],
        ]);

        $detalle->update([
            'matricula_requisitos_id' => $data['matricula_requisitos_id'],
            'descripcion'             => $data['descripcion'],
            'is_active'               => $request->boolean('is_active'),
        ]);

        return redirect()->route('matri-detalle-requisitos.index')->with('success', 'Registro actualizado.');
    }

    public function destroy(MatriculaDetalleRequisito $detalle)
    {
        // Soft delete (si prefieres hard delete: $detalle->forceDelete();)
        $detalle->delete();
        return redirect()->route('matri-detalle-requisitos.index')->with('success', 'Registro eliminado.');
    }
}
