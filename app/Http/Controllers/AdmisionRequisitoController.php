<?php

namespace App\Http\Controllers;

use App\Models\AdmisionRequisito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdmisionRequisitoController extends Controller
{
    public function index()
    {
        // Traemos los requisitos con el nombre del tipo (join) y orden ascendente por id
        $items = DB::table('admision_requisitos as r')
            ->leftJoin('admision_documentos as d', 'd.id', '=', 'r.admision_documentos_id')
            ->select('r.*', 'd.nombre as tipo_nombre')
            ->whereNull('r.deleted_at')
            ->orderBy('r.id', 'asc')
            ->get();

        // Opciones para el combobox (no hace falta modelo)
        $tipos = DB::table('admision_documentos')
            ->select('id', 'nombre')
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.admision_matricula.admision.requisitos.index', compact('items', 'tipos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'admision_documentos_id' => ['required','integer','exists:admision_documentos,id'],
            'titulo'                 => ['required','string','max:200'],
            'descripcion'            => ['required','string'],
            'is_active'              => ['nullable','boolean'],
        ]);

        AdmisionRequisito::create([
            'admision_documentos_id' => $data['admision_documentos_id'],
            'titulo'                 => $data['titulo'],
            'descripcion'            => $data['descripcion'],
            'is_active'              => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin-requisitos.index')->with('success','Registro creado.');
    }

    public function update(Request $request, AdmisionRequisito $requisito)
    {
        $data = $request->validate([
            'admision_documentos_id' => ['required','integer','exists:admision_documentos,id'],
            'titulo'                 => ['required','string','max:200'],
            'descripcion'            => ['required','string'],
            'is_active'              => ['nullable','boolean'],
        ]);

        $requisito->update([
            'admision_documentos_id' => $data['admision_documentos_id'],
            'titulo'                 => $data['titulo'],
            'descripcion'            => $data['descripcion'],
            'is_active'              => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin-requisitos.index')->with('success','Registro actualizado.');
    }

    public function destroy(AdmisionRequisito $requisito)
    {
        // HARD DELETE (elimina físicamente aunque haya SoftDeletes)
        $requisito->forceDelete();

        return redirect()->route('admin-requisitos.index')->with('success','Registro eliminado.');
    }
}
