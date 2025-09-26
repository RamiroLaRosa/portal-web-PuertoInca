<?php

namespace App\Http\Controllers;

use App\Models\BecaTipo;
use App\Models\BecaBeneficiario;
use App\Models\BecaProceso;
use Illuminate\Support\Facades\DB;

class BecasController extends Controller
{
    public function index()
    {
        // Tipos de beca
        $becas = BecaTipo::activos()
            ->orderBy('id') // <= sin 'orden', ordena por id
            ->get([
                'titulo',
                'descripcion',
                'icono',
                DB::raw('requisito as badge'), // 'badge' no existe; mapeamos 'requisito'
            ]);

        // Beneficiarios agrupados por programa (esto no cambia)
        $beneficiarios = BecaBeneficiario::activos()
            ->with(['programa:id,nombre', 'tipo:id,titulo'])
            ->orderBy('programa_id')->orderBy('id')
            ->get(['programa_id', 'tipo_beca_id', 'nombre'])
            ->groupBy(fn($b) => $b->programa?->nombre ?? 'Sin programa');

        $procesos = BecaProceso::where('is_active', 1)
            ->orderBy('nro_paso')
            ->get(['nro_paso', 'titulo', 'descripcion']);

        return view('admision.becas', compact('becas', 'beneficiarios', 'procesos'));
    }
}
