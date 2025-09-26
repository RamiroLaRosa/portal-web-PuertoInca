<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $programasTotal = DB::table('programas_estudios')
            ->where('is_active', 1)
            ->whereNull('deleted_at')
            ->count();

        $programas = DB::table('programas_estudios')
            ->where('is_active', 1)
            ->whereNull('deleted_at')
            ->orderBy('nombre')
            ->pluck('nombre');   // <- solo nombres

        $docentesPorPrograma = DB::table('plana_docente as pd')
            ->join('programas_estudios as pe', 'pe.id', '=', 'pd.programa_estudio_id')
            ->where('pd.is_active', 1)->whereNull('pd.deleted_at')
            ->where('pe.is_active', 1)->whereNull('pe.deleted_at')
            ->groupBy('pe.id', 'pe.nombre')
            ->orderBy('pe.nombre')
            ->pluck(DB::raw('COUNT(pd.id) as total'), 'pe.nombre');

        $docProgLabels = array_keys($docentesPorPrograma->toArray());
        $docProgData   = array_values($docentesPorPrograma->toArray());

        return view('admin.dashboard.index', [
            'programasTotal' => $programasTotal,
            'programas'      => $programas,  
            'docProgLabels'  => $docProgLabels,
            'docProgData'    => $docProgData,
        ]);
    }
}
