<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\header\HeaderController;
use App\Http\Controllers\sidebar\SidebarController;
use App\Models\Administrator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class AdministratorProfileController extends Controller
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
                return view('admin.profile.index')->with('datatipoacceso', $tipoacceso)->with('datalist', $sidebar)->with('dataarea', $dataAreaNombre);
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


    // public function index(Request $request)
    // {

    //     $objeto = new SidebarController();

    //     $sidebar = $objeto->ListmodulosSidebar();

    //     if (Auth::check()) {
    //         $userTypeAccesocombo = $request->session()->get('userTypeAccesocombo');
    //         if ($userTypeAccesocombo == "1") {
    //             //si el usuario esta autentificado es docente o estudiante no le pasamos la lista del sidebar
    //             $tipoacceso = 1;
    //             return view('admin.profile.index')->with('datatipoacceso', $tipoacceso)->with('datalist', $sidebar)->with('dataarea', $dataAreaNombre);
    //         } else if ($userTypeAccesocombo == "2") {
    //             //si el usuario esta autentificado es docente o estudiante no le pasamos la lista del sidebar
    //             return redirect()->route('home.docente.dashboard')->withSuccess('Opps! You do not have access');
    //         } else if ($userTypeAccesocombo == "3") {
    //             //si el usuario esta autentificado es docente o estudiante no le pasamos la lista del sidebar
    //             return redirect()->route('home.student.index')->withSuccess('Opps! You do not have access');
    //         }
    //     } else {
    //         return redirect()->route('login')->withSuccess('Opps! You do not have access');
    //     }
    // }

    
    public function data(Request $request)
    {
        $user = Auth::user();
        $administratordata = $user->administradores;
        $idadministrator = $administratordata[0]->id;

        if ($request->ajax()) {

            $data = DB::table('administradores as ad')
                ->join('usuarios as us', 'us.id', '=', 'ad.user_id')
                ->join('generos as ge', 'ge.id', '=', 'us.genre_id')
                ->join('ubigeos as ub', 'ub.id', '=', 'us.ubigeo_id')
                ->join('roles as ro', 'ro.id', '=', 'ad.role_id')
                ->join('td_areas as ta', 'ta.id', '=', 'ro.tdarea_id')
                ->join('tipos_identificaciones AS it', 'it.id', '=', 'us.identificationtype_id')
                ->select(
                    'ad.id as idadmin',
                    'ro.id as idrol',
                    'ro.nombre as rol',
                    'ro.descripcion as descripcion',
                    'ta.id as idtdarea',
                    'ta.NOMBRE as nomarea',
                    'us.id as iduser',
                    'it.id AS ididentificationtype',
                    'it.tipo AS tipoidenti',
                    'us.nroidenti',
                    'us.password',
                    DB::raw("CONCAT(it.tipo, ' - ', us.nroidenti) as identificacion"),
                    DB::raw("CONCAT(us.nombres, ' ', us.apellido_pa, ' ', us.apellido_ma) as administrador"),
                    'us.fecnac',
                    'us.correo',
                    'us.telefono',
                    'us.celular',
                    'us.direccion',
                    'us.ubigeo_id',
                    'ge.id as idgenero',
                    'ge.nombre as genero',
                    'ub.id as idubigeo',
                    DB::raw('SUBSTRING(ub.id, 1, 2) AS iddepartamento'),
                    'ub.departamento',
                    DB::raw('SUBSTRING(ub.id, 3, 2) AS idprovincia'),
                    'ub.provincia',
                    DB::raw('SUBSTRING(ub.id, 5, 2) AS iddistrito'),
                    'ub.distrito'
                )

                ->where('ad.id', '=', $idadministrator)
                ->get();


            return response()->json($data);
        }
        return  response()->json(["status" => false, "mensaje" => 'Error en request']);
    }


    public function update(Request $request)
    {
        $id = Auth::user()->id;

        $item = User::find($id);

        // validar existencia del registro
        if (!$item) {
            abort(404);
        } else {

            $item->genre_id = $request->input('txt_genero');
            $item->fecnac = $request->input('txt_fecnac');
            $item->correo = $request->input('txt_correo');
            $item->telefono = $request->input('txt_telefono');
            $item->celular = $request->input('txt_celular');
            $item->direccion = $request->input('txt_direccion');
            $idubigeo = $request->input('txt_departamento') . $request->input('txt_provincia') . $request->input('txt_distrito');
            $item->ubigeo_id = $idubigeo;
            // validar guardado
            if ($item->save()) {
                // El guardado fue exitoso
                return response()->json(["status" => true, "mensaje" => 'Datos actualizados']);
            } else {
                // El guardado falló
                return response()->json(["status" => false, "mensaje" => 'Datos no actualizados']);
            }
        }
    }

    public function update_password(Request $request)
    {
        $id = Auth::user()->id;
        $password = Auth::user()->password;
        $pass_actual = $request->input('txt_password1');
        $pass_nueva = $request->input('txt_password2');

        // if (Hash::check($pass_actual, $password)) {
        //     return response()->json([
        //         "status" => true,
        //         "mensaje" => "iguales"
        //     ]);
        // } else {
        //     return response()->json([
        //         "status" => false,
        //         "mensaje" => " no iguales"
        //     ]);
        // }

        if ( Hash::check($pass_actual, $password) ) {

            $item = User::find($id);

            // validar existencia del registro
            if (!$item) {
                abort(404);
            } else {
                // recoger datos
                $item->password = $request->input('txt_password2');
                // validar guardado
                if ($item->save()) {
                    return response()->json(["status" => true, "mensaje" => 'Registro actualizado']);
                } else {
                    return response()->json(["status" => false, "mensaje" => 'Registro no actualizado']);
                }
            }

        } else {
            return response()->json([
                "status" => false,
                "errors" => ["Credenciales inválidas"]
            ]);
        }


    }
}
