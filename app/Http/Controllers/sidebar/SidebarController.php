<?php

namespace App\Http\Controllers\sidebar;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class SidebarController extends Controller
{

    public function ListmodulosSidebar()
    {
        $userId = Auth::User()->id;

        $result = Administrator::join('usuarios as u', 'administradores.user_id', '=', 'u.id')
            ->join('roles as r', 'administradores.role_id', '=', 'r.id')
            ->join('permisos as p', 'administradores.role_id', '=', 'p.role_id')
            ->join('modulos as m', 'p.module_id', '=', 'm.id')
            ->select(
                'u.nroidenti',
                'u.nombres as nombreusuario',
                'r.id as idrol',
                'r.nombre as nombrerol',
                'p.module_id as idpermiso',
                'm.nombre as nombremodulo',
                DB::raw('IF(p.estado = 1, "Activo", "Inactivo") as estadomodulo')
            )
            ->where('u.id', '=', $userId)
            ->get();

        return $result;
    }
    
    public function ConsultaAccessRouteModule($id_module)
    {
        $userId = Auth::User()->id;

        $result = Administrator::select(
            'administradores.id as id_adm',
            'b.id as id_roles',
            'b.nombre',
            'b.descripcion',
            'c.id as id_permission',
            'c.estado',
            'm.id as id_modulos',
            'm.nombre as name_module'
        )
            ->join('roles as b', 'administradores.role_id', '=', 'b.id')
            ->join('permisos as c', 'administradores.role_id', '=', 'c.role_id')
            ->join('modulos as m', 'c.module_id', '=', 'm.id')
            ->where('administradores.user_id', $userId)
            ->where('c.module_id', $id_module)
            ->where('c.estado', '1')
            ->get();

        return $result;
    }
}
