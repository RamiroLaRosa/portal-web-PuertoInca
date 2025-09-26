<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\header\HeaderController;
use App\Http\Controllers\sidebar\SidebarController;
use App\Models\Identificationtype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class IdentificationtypeController extends Controller
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
                return view('admin.institucion.tiposidenti.index')->with('datatipoacceso', $tipoacceso)->with('datalist', $sidebar)->with('dataarea', $dataAreaNombre);
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

            $data = Identificationtype::get();

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

        $item = new Identificationtype();
        $item->tipo = $request->input('txt-tipo');
        // Asigna otros campos según tus necesidades

        // Guarda el nuevo registro en la base de datos
        if ($item->save()) {
            return response()->json(["status" => true, "mensaje" => 'Registro insertado']);
        } else {
            return response()->json(["status" => false, "mensaje" => 'Registro no insertado']);
        }
    }


    public function ajax_all(Request $request)
    {
        if ($request->ajax()) {

            $data = Identificationtype::get();

            return response()->json($data);
        }
        return  response()->json(["status" => false, "mensaje" => 'Error en request']);
    }


    public function update(Request $request, $id)
    {
        $item = Identificationtype::find($id);

        if (!$item) {
            abort(404); // Manejo de error si no se encuentra el registro
        } else {
            $item->tipo = $request->input('txt-tipo');

            if ($item->save()) {
                return response()->json(["status" => true, "mensaje" => 'Registro actualizado']);
            } else {
                return response()->json(["status" => false, "mensaje" => 'Registro no actualizado']);
            }
        }
    }


    public function destroy($id)
    {
        // Busca el registro por su ID
        $item = Identificationtype::find($id);

        // Verifica si el registro existe
        if (!$item) {
            return response()->json(["status" => false, "mensaje" => 'El registro no existe']);
        }

        // Verifica si hay relaciones antes de intentar eliminar
        if ($item->users()->exists()) {
            return response()->json(["status" => false, "mensaje" => 'Hay usuarios con este tipo de identificación']);
        }

        // Elimina el registro de la base de datos
        if ($item->delete()) {
            return response()->json(["status" => true, "mensaje" => 'El registro fue eliminado']);
        } else {
            return response()->json(["status" => false, "mensaje" => 'El registro no fue eliminado']);
        }
    }
}
