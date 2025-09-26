<?php

namespace App\Http\Controllers;

use App\Models\BecaBeneficiario;
use App\Models\ProgramasEstudio;
use App\Models\BecaTipo;
use Illuminate\Http\Request;

class BecaBeneficiarioController extends Controller
{
    public function index(Request $request)
    {
        // Programas y tipos para combos
        $programas = ProgramasEstudio::where('is_active', 1)
            ->orderBy('nombre')->get(['id','nombre']);

        $tipos = BecaTipo::where('is_active', 1)
            ->orderBy('titulo')->get(['id','titulo']);

        // Filtro por programa (opcional). Si no está seleccionado, no listamos nada.
        $programaId = $request->query('programa');

        $items = collect();
        if (!empty($programaId)) {
            $items = BecaBeneficiario::with(['programa','tipo'])
                ->where('programa_id', $programaId)
                ->orderBy('id','asc')
                ->get();
        }

        return view('admin.admision_matricula.beca.beneficiarios.index', compact(
            'programas','tipos','items','programaId'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'programa_id'  => ['required','integer','exists:programas_estudios,id'],
            'tipo_beca_id' => ['required','integer','exists:becas_tipo,id'],
            'nombre'       => ['required','string','max:150'],
            'is_active'    => ['nullable','boolean'],
        ]);

        BecaBeneficiario::create([
            'programa_id'  => $data['programa_id'],
            'tipo_beca_id' => $data['tipo_beca_id'],
            'nombre'       => $data['nombre'],
            'is_active'    => $request->boolean('is_active'),
        ]);

        return back()->with('success','Beneficiario creado.');
    }

    public function update(Request $request, BecaBeneficiario $beneficiario)
    {
        $data = $request->validate([
            'programa_id'  => ['required','integer','exists:programas_estudios,id'],
            'tipo_beca_id' => ['required','integer','exists:becas_tipo,id'],
            'nombre'       => ['required','string','max:150'],
            'is_active'    => ['nullable','boolean'],
        ]);

        $beneficiario->update([
            'programa_id'  => $data['programa_id'],
            'tipo_beca_id' => $data['tipo_beca_id'],
            'nombre'       => $data['nombre'],
            'is_active'    => $request->boolean('is_active'),
        ]);

        return back()->with('success','Beneficiario actualizado.');
    }

    public function destroy(BecaBeneficiario $beneficiario)
    {
        $beneficiario->delete(); // SoftDelete
        return back()->with('success','Beneficiario eliminado.');
    }
}
