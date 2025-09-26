<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\header\HeaderController;
use App\Http\Controllers\sidebar\SidebarController;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{


    public function index(Request $request)
    {
        $objeto = new SidebarController();

        $sidebar = $objeto->ListmodulosSidebar();

        if (Auth::check()) {
            $userTypeAccesocombo = $request->session()->get('userTypeAccesocombo');

            $idusertype = Auth::User()->usertype_id;

            if ($userTypeAccesocombo == "1" && ($idusertype == "1" || $idusertype == "4" || $idusertype == "5" || $idusertype == "7")) {
                $objetoarea = new HeaderController();
                $dataarea = $objetoarea->DataAreaAdm();
                $tipoacceso = 1;
                $dataAreaNombre = $dataarea[0]['NOMBRE'];;
                //si el usuario esta autentificado es admin le pasamos la lista del sidebar
                return view('admin.seguridad.permisos.index')->with('datatipoacceso', $tipoacceso)->with('datalist', $sidebar)->with('dataarea', $dataAreaNombre);
            } else if ($userTypeAccesocombo == "2"){
                //si el usuario esta autentificado es docente o estudiante no le pasamos la lista del sidebar
                return redirect()->route('home.docente.index')->withSuccess('Opps! You do not have access');
            }else if ($userTypeAccesocombo == "3"){
                //si el usuario esta autentificado es docente o estudiante no le pasamos la lista del sidebar
                return redirect()->route('home.student.index')->withSuccess('Opps! You do not have access');
            }
        } else {
            return redirect()->route('login')->withSuccess('Opps! You do not have access');
        }
    }



    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::join('modulos AS m', 'permisos.module_id', '=', 'm.id')
                ->join('roles AS r', 'permisos.role_id', '=', 'r.id')
                ->where('r.id', '!=', 1)
                ->orderBy('r.id','asc')
                ->get([
                    'r.id AS idrol',
                    'r.nombre AS rol',
                    'r.descripcion AS descripcion',
                    'm.id AS idmodulo',
                    'm.nombre AS modulo',
                    'permisos.estado AS permiso',
                ]);

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return  response()->json([
            "status" => false,
            "mensaje" => 'Error: no se pueden cargar los archivos'
        ]);
    }


    public function ajax_all(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::all();
            return response()->json($data);
        }
        return  response()->json([
            "status" => false,
            "mensaje" => 'Error en request'
        ]);
    }


    public function update(Request $request, $idrol, $idmodulo)
    {

        $validator = Validator::make($request->all(), [
            'txt_permiso_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "mensaje" => $validator->errors()
            ]);
        }

        //$item = Permission::find($idrol, $idmodulo);
        $item = Permission::where('role_id', $idrol)
            ->where('module_id', $idmodulo)
            ->first();

        if (!$item) {
            abort(404); // Manejo de error si no se encuentra el registro
        } else {
            $item->estado = $request->input('txt_permiso_name');

            if ($item->save()) {
                // El guardado fue exitoso
                return response()->json([
                    "status" => true,
                    "mensaje" => 'Permiso actualizado'
                ]);
            } else {
                // El guardado falló
                return response()->json([
                    "status" => false,
                    "mensaje" => 'El permiso no pudo ser actualizado'
                ]);
            }
        }
    }

}
