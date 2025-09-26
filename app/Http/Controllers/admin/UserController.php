<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\sidebar\SidebarController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function ajax_all_by_nroidenti(Request $request, $nroidenti)
    {
        if ($request->ajax()) {
            $data = User::where('nroidenti', $nroidenti)->get();
            return response()->json($data);
        }
        return  response()->json(["status" => false, "mensaje" => 'Error en request']);
    }

    public function query_bd($nroidenti)
    {
        $response = User::join('tipos_identificaciones AS it', 'it.id', '=', 'usuarios.identificationtype_id')
            ->join('tipos_usuarios AS ut', 'ut.id', '=', 'usuarios.usertype_id')
            ->join('ubigeos AS ub', 'ub.id', '=', 'usuarios.ubigeo_id')
            ->join('generos AS g', 'g.id', '=', 'usuarios.genre_id')
            ->orderBy('usuarios.apellido_pa', 'asc')
            ->orderBy('usuarios.apellido_ma', 'asc')
            ->orderBy('usuarios.nombres', 'asc')
            ->get([
                'usuarios.id AS iduser',
                'usuarios.nroidenti',
                'usuarios.password',
                'usuarios.nombres',
                'usuarios.apellido_pa',
                'usuarios.apellido_ma',
                DB::raw('CONCAT(usuarios.apellido_pa, " ", usuarios.apellido_ma) AS apellidos'),
                'usuarios.fecnac', 
                'usuarios.correo', 
                'usuarios.telefono', 
                'usuarios.celular', 
                'usuarios.direccion', 
                'usuarios.estado',
                'it.id AS ididentificationtype', 
                'it.tipo AS tipoidenti',
                'ut.id AS idusertype',
                'ut.tipo',
                'ub.id AS idubigeo', 
                DB::raw('SUBSTRING(ub.id, 1, 2) AS iddepartamento'), 
                'ub.departamento', 
                DB::raw('SUBSTRING(ub.id, 3, 2) AS idprovincia'), 
                'ub.provincia', 
                DB::raw('SUBSTRING(ub.id, 5, 2) AS iddistrito'), 
                'ub.distrito',
                'g.id AS idgenre', 
                'g.nombre AS nombregenre'
            ])->where('nroidenti', $nroidenti);

        return response()->json([
            "status" => true,
            "mensaje" => 'Consulta realizada',
            "data" => $response
        ]);
    }
}
