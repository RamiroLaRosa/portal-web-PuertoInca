<?php

namespace App\Http\Controllers;

use App\Models\Estadistica;
use App\Models\TemaEstadistico;
use App\Models\AnioEstadistico;
use App\Models\ProgramasEstudio;   // 👈 nombre corregido
use Illuminate\Http\Request;

class EstadisticaCrudController extends Controller
{
    public function index()
    {
        $temas     = TemaEstadistico::where('is_active', 1)->orderBy('tema')->get(['id','tema']);
        $anios     = AnioEstadistico::where('is_active', 1)->orderBy('anio')->get(['id','anio']);
        $programas = ProgramasEstudio::where('is_active', 1)->orderBy('nombre')->get(['id','nombre']);

        return view('admin.transparencia.estadistica.index', compact('temas','anios','programas'));
    }

    // AJAX: matriz programa × año para un tema
    public function grid(Request $request)
    {
        $validated = $request->validate([
            'tema_id' => ['required','integer','exists:tema_estadistico,id']
        ]);

        $temaId    = (int) $validated['tema_id'];
        $anios     = AnioEstadistico::where('is_active',1)->orderBy('anio')->get(['id','anio']);
        $programas = ProgramasEstudio::where('is_active',1)->orderBy('nombre')->get(['id','nombre']);

        $regs = Estadistica::where('tema_estadistico_id', $temaId)
            ->where('is_active', 1)
            ->get(['id','programa_estudio_id','anio_estadistico_id','cantidad']);

        $cells = [];
        foreach ($regs as $r) {
            $key = $r->programa_estudio_id . '-' . $r->anio_estadistico_id;
            $cells[$key] = ['id' => $r->id, 'cantidad' => (int)$r->cantidad];
        }

        return response()->json([
            'years'    => $anios,
            'programs' => $programas,
            'cells'    => $cells,
        ]);
    }

    // Crea o actualiza combinación (tema+programa+año)
    public function store(Request $request)
    {
        $data = $request->validate([
            'tema_estadistico_id' => ['required','integer','exists:tema_estadistico,id'],
            'programa_estudio_id' => ['required','integer','exists:programas_estudios,id'],
            'anio_estadistico_id' => ['required','integer','exists:anio_estadistico,id'],
            'cantidad'            => ['required','integer','min:0'],
            'is_active'           => ['nullable','boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        $reg = Estadistica::firstOrNew([
            'tema_estadistico_id' => $data['tema_estadistico_id'],
            'programa_estudio_id' => $data['programa_estudio_id'],
            'anio_estadistico_id' => $data['anio_estadistico_id'],
        ]);

        $reg->fill([
            'cantidad'  => $data['cantidad'],
            'is_active' => $data['is_active'],
        ])->save();

        return back()->with('success', 'Registro guardado correctamente.');
    }

    public function update(Request $request, Estadistica $estadistica)
    {
        $data = $request->validate([
            'cantidad'  => ['required','integer','min:0'],
            'is_active' => ['nullable','boolean'],
        ]);

        $estadistica->cantidad  = $data['cantidad'];
        $estadistica->is_active = $request->boolean('is_active', true);
        $estadistica->save();

        return back()->with('success', 'Registro actualizado.');
    }

    public function destroy(Estadistica $estadistica)
    {
        $estadistica->delete();
        return back()->with('success', 'Registro eliminado.');
    }
}
