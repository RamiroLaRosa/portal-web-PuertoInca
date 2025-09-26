<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Ubigeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UbigeoController extends Controller
{

    public function ajax_all_ubigeo_provincias(Request $request, $departamento)
    {
        if ($request->ajax()) {
            $data = DB::table('ubigeos')
                ->select(DB::raw("DISTINCT SUBSTRING(id, 3, 2) AS idprovincia"), 'provincia')
                ->where('departamento', $departamento)
                ->orderBy('provincia')
                ->get();
            return response()->json($data);
        }
        return  response()->json([
            "status" => false,
            "mensaje" => 'Error en request'
        ]);
    }

    public function ajax_all_ubigeo_distritos(Request $request, $provincia)
    {
        if ($request->ajax()) {
            $data = DB::table('ubigeos')
                ->select(DB::raw("DISTINCT SUBSTRING(id, 5, 2) AS iddistrito"), 'distrito')
                ->where('provincia', $provincia)
                ->orderBy('distrito')
                ->get();
            return response()->json($data);
        }
        return  response()->json([
            "status" => false,
            "mensaje" => 'Error en request'
        ]);
    }
}
