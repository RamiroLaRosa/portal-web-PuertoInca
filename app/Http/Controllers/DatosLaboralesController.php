<?php

namespace App\Http\Controllers;

use App\Models\DatoLaboral;
use App\Models\PlanaDocente;
use App\Models\ProgramasEstudio;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DatosLaboralesController extends Controller
{
    public function index()
    {
        $programas = ProgramasEstudio::orderBy('nombre')->get(['id','nombre']);
        return view('admin.nosotros.docente.laborales.index', compact('programas'));
    }

    // GET /docentes?programa=ID
    public function docentesPorPrograma(Request $request)
    {
        $programa = (int) $request->query('programa', 0);
        if ($programa <= 0) return response()->json(['data' => []]);

        $data = PlanaDocente::where('programa_estudio_id', $programa)
            ->orderBy('nombre')
            ->get(['id','nombre']);

        return response()->json(['data' => $data]);
    }

    // GET /list?docente=ID
    public function list(Request $request)
    {
        $docente = (int) $request->query('docente', 0);
        if ($docente <= 0) return response()->json(['data' => []]);

        $data = DatoLaboral::where('docente_id', $docente)
            ->orderBy('id')
            ->get([
                'id','docente_id','institucion','cargo','experiencia',
                'inicio_labor','termino_labor','tiempo_cargo'
            ]);

        return response()->json(['data' => $data]);
    }

    public function show($id)
    {
        $d = DatoLaboral::findOrFail($id);
        return response()->json($d);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'docente_id'   => 'required|exists:plana_docente,id',
            'institucion'  => 'required|string|max:255',
            'cargo'        => 'required|string|max:255',
            'experiencia'  => 'nullable|string|max:255',
            'inicio_labor' => 'required|date',
            'termino_labor'=> 'required|date|after_or_equal:inicio_labor',
        ]);

        $validated['tiempo_cargo'] = $this->diffHumana($validated['inicio_labor'], $validated['termino_labor']);
        $validated['is_active'] = 1;

        $row = DatoLaboral::create($validated);

        return response()->json(['ok' => true, 'row' => $row]);
    }

    public function update(Request $request, $id)
    {
        $row = DatoLaboral::findOrFail($id);

        $validated = $request->validate([
            'docente_id'   => 'required|exists:plana_docente,id',
            'institucion'  => 'required|string|max:255',
            'cargo'        => 'required|string|max:255',
            'experiencia'  => 'nullable|string|max:255',
            'inicio_labor' => 'required|date',
            'termino_labor'=> 'required|date|after_or_equal:inicio_labor',
        ]);

        $validated['tiempo_cargo'] = $this->diffHumana($validated['inicio_labor'], $validated['termino_labor']);

        $row->update($validated);

        return response()->json(['ok' => true, 'row' => $row]);
    }

    public function destroy($id)
    {
        $row = DatoLaboral::findOrFail($id);
        $row->delete();
        return response()->json(['ok' => true]);
    }

    private function diffHumana(string $inicio, string $fin): string
    {
        $a = Carbon::parse($inicio);
        $b = Carbon::parse($fin);
        $years = $a->diffInYears($b);
        $monthsTotal = $a->diffInMonths($b);
        $months = $monthsTotal % 12;

        $p1 = $years ? $years.' año'.($years>1?'s':'') : '';
        $p2 = $months ? $months.' mes'.($months>1?'es':'') : '';
        $txt = trim($p1.' '.$p2);
        return $txt !== '' ? $txt : '0 meses';
    }
}