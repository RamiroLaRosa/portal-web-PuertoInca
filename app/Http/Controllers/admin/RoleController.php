<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\header\HeaderController;
use App\Http\Controllers\sidebar\SidebarController;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
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
                return view('admin.seguridad.roles.index')->with('datatipoacceso', $tipoacceso)->with('datalist', $sidebar)->with('dataarea', $dataAreaNombre);
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
            $data = DB::table('roles as ro')
                ->leftJoin('td_areas as ta', 'ro.tdarea_id', '=', 'ta.id')
                ->select('ro.id as idrole', 'ro.nombre as nombrerole', 'ro.descripcion', 'ta.id as idarea', 'ta.NOMBRE as nombrearea')
                ->get();

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

        $item = new Role();
        $item->tdarea_id = $request->input('txt-area');
        $item->nombre = $request->input('text_nombre_name');
        $item->descripcion = $request->input('text_descripcion_name');
        // Asigna otros campos según tus necesidades

        // Guarda el nuevo registro en la base de datos
        if ($item->save()) {
            // Last inserted id
            $newRoleId = $item->id;

            // Crear registros para permisos
            // tr_roles_after_insert
            for ($moduleId = 1; $moduleId <= 13; $moduleId++) {
                Permission::create([
                    'role_id' => $newRoleId,
                    'module_id' => $moduleId,
                    'estado' => 0,
                ]);
            }

            // El guardado fue exitoso
            return response()->json(["status" => true, "mensaje" => 'Registro realizado']);
        } else {
            // El guardado falló
            return response()->json(["status" => false, "mensaje" => 'Registro no realizado']);
        }
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

        $item = Role::find($id);

        if (!$item) {
            abort(404); // Manejo de error si no se encuentra el registro
        } else {
            $item->tdarea_id = $request->input('txt-area');
            $item->nombre = $request->input('text_nombre_name');
            $item->descripcion = $request->input('text_descripcion_name');

            if ($item->save()) {
                // El guardado fue exitoso
                return response()->json(["status" => true, "mensaje" => 'Registro actualizado']);
            } else {
                // El guardado falló
                return response()->json(["status" => false, "mensaje" => 'Registro no actualizado']);
            }
        }
    }


    public function destroy($id)
    {
        // Busca el registro por su ID
        $role = Role::find($id);

        // Verifica si el registro existe
        if (!$role) {
            return response()->json(["status" => false, "mensaje" => 'El registro no existe']);
        }

        // Elimina el registro de la base de datos
        if ($role->delete()) {
            return response()->json(["status" => true, "mensaje" => 'El registro fue eliminado']);
        } else {
            return response()->json(["status" => false, "mensaje" => 'El registro no fue eliminado']);
        }
    }


    public function ajax_all(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::all();
            return response()->json($data);
        }
        return  response()->json(["status" => false, "mensaje" => 'Error en request']);
    }

    public function ajax_all2(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::where('id', '!=', 1)->get();
            return response()->json($data);
        }
        return  response()->json(["status" => false, "mensaje" => 'Error en request']);
    }
}
