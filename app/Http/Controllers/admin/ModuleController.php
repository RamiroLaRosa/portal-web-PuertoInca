<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\header\HeaderController;
use App\Http\Controllers\sidebar\SidebarController;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ModuleController extends Controller
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
                return view('admin.seguridad.modulos.index')->with('datatipoacceso', $tipoacceso)->with('datalist', $sidebar)->with('dataarea', $dataAreaNombre);
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

            // query
            $data = Module::join('roles AS r', 'r.id', '=', 'administradores.role_id')
                ->join('usuarios AS u', 'u.id', '=', 'administradores.user_id')
                ->join('tipos_identificaciones AS it', 'it.id', '=', 'u.identificationtype_id')
                ->join('tipos_usuarios AS ut', 'ut.id', '=', 'u.usertype_id')
                ->join('ubigeos AS ub', 'ub.id', '=', 'u.ubigeo_id')
                ->join('generos AS g', 'g.id', '=', 'u.genre_id')
                ->get([
                    'administradores.id AS idadministrador',
                    'r.id AS idrole', 'r.nombre AS nombrerole',
                    'u.id AS iduser',
                    'it.id AS ididentificationtype','it.tipo AS tipoidenti',
                    'u.nroidenti', 'u.password', 'u.nombres', 'u.apellido_pa', 'u.apellido_ma', DB::raw('CONCAT(u.apellido_pa, " ", u.apellido_ma) AS apellidos'), 'u.fecnac', 'u.correo', 'u.telefono', 'u.celular', 'u.direccion', 'u.estado',
                    'ut.id AS idusertype', 'ut.tipo',
                    'ub.id AS idubigeo', 'ub.departamento', 'ub.provincia', 'ub.distrito',
                    'g.id AS idgenre', 'g.nombre AS nombregenre'
                ]);

            return \Yajra\DataTables\DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return  response()->json([
            "status" => false,
            "mensaje" => 'Error: no se pueden cargar los archivos'
        ]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text_nombre_name' => 'required',
            'text_descripcion_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors()
            ]);
        }

        $item = new Module();
        $item->nombre = $request->input('text_nombre_name');
        $item->descripcion = $request->input('text_descripcion_name');
        // Asigna otros campos según tus necesidades

        // Guarda el nuevo registro en la base de datos
        if ($item->save()) {
            // El guardado fue exitoso
            return response()->json([
                "status" => true,
                "mensaje" => 'Éxito: registros realizado'
            ]);
        } else {
            // El guardado falló
            return response()->json([
                "status" => false,
                "mensaje" => 'Error: registros no realizado'
            ]);
        }
    }


    public function ajax_all(Request $request)
    {
        if ($request->ajax()) {
            $data = Module::all();
            return response()->json($data);
        }
        return  response()->json([
            "status" => false,
            "mensaje" => 'Error en request'
        ]);
    }


    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'text_nombre_name' => 'required',
            'text_descripcion_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "mensaje" => $validator->errors()
            ]);
        }

        $item = Module::find($id);

        if (!$item) {
            abort(404); // Manejo de error si no se encuentra el registro
        } else {
            $item->nombre = $request->input('text_nombre_name');
            $item->descripcion = $request->input('text_descripcion_name');

            if ($item->save()) {
                // El guardado fue exitoso
                return response()->json([
                    "status" => true,
                    "mensaje" => 'Éxito: registros actualizado'
                ]);
            } else {
                // El guardado falló
                return response()->json([
                    "status" => false,
                    "mensaje" => 'Error: registros no pudo ser actualizado'
                ]);
            }
        }
    }

    public function destroy($id)
    {
        // Busca el registro por su ID
        $Module = Module::find($id);

        // Verifica si el registro existe
        if (!$Module) {
            return response()->json([
                "status" => false,
                "mensaje" => 'Error, el registro no existe'
            ]);
        }

        // Elimina el registro de la base de datos
        if ($Module->delete()) {
            return response()->json([
                "status" => true,
                "mensaje" => 'Éxito, el registro fue eliminado'
            ]);
        } else {
            return response()->json([
                "status" => false,
                "mensaje" => 'Error, al eliminar registro'
            ]);
        }
    }
}
