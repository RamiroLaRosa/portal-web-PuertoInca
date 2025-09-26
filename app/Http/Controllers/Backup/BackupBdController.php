<?php

namespace App\Http\Controllers\Backup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\sidebar\SidebarController;
use App\Http\Controllers\header\HeaderController;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Auth;
use App\Models\Administrator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Models\Backuphistory;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Backup\Tasks\Backup\BackupJob;

class BackupBdController extends Controller
{
    //

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
                return view('admin.seguridad.backup.index')->with('datatipoacceso', $tipoacceso)->with('datalist', $sidebar)->with('dataarea', $dataAreaNombre);
            } else if ($userTypeAccesocombo == "2") {
                //si el usuario esta autentificado es docente o estudiante no le pasamos la lista del sidebar
                return redirect()->route('home.docente.index')->withSuccess('Opps! You do not have access');
            } else if ($userTypeAccesocombo == "3") {
                //si el usuario esta autentificado es docente o estudiante no le pasamos la lista del sidebar
                return redirect()->route('home.student.index')->withSuccess('Opps! You do not have access');
            }
        } else {
            return redirect()->route('login')->withSuccess('Opps! You do not have access');
        }
    }
    public function createBackupBD(Request $request)
    {
        // Ejecutar la lógica para realizar el respaldo aquí
        try {

            // Ejecutar el comando de respaldo de base de datos
            Artisan::call('backup:run --only-db --disable-notifications'); // LINUX - VPS
            // Artisan::call('backup:run --only-files --disable-notifications'); // WINDOWS

            $output = Artisan::output(); // Capturar la salida del comando
            if ($output) {

                // Obtener la ruta completa de la carpeta backup dentro de app
                $backupFolderPath = storage_path('app/SGAHUANUCO');

                // Verificar si la carpeta existe
                if (file_exists($backupFolderPath)) {
                    // Obtener la lista de archivos en la carpeta backup
                    $files = scandir($backupFolderPath, SCANDIR_SORT_DESCENDING);

                    // Eliminar . y .. de la lista de archivos
                    $files = array_diff($files, ['.', '..']);

                    // Obtener el primer archivo (último por orden descendente)
                    $latestFile = reset($files);

                    // Obtener la ruta completa del último archivo
                    $latestFilePath = $backupFolderPath . DIRECTORY_SEPARATOR . $latestFile;

                    // Verificar si el archivo existe
                    if (file_exists($latestFilePath)) {

                        $item = new Backuphistory();
                        $administrador_id = Administrator::where('user_id', Auth::User()->id)->first();

                        $item->nombre = $latestFile;
                        $item->estado = "1";
                        $item->administrator_id = $administrador_id->id;

                        // Guarda el nuevo registro en la base de datos
                        if ($item->save()) {
                            // El guardado fue exitoso
                            return response()->json(["status" => true, 'mensaje' => 'Respaldo exitoso']);
                        } else {
                            // El guardado falló
                            return response()->json(["status" => false, 'mensaje' => 'Respaldo No exitoso']);
                        }
                    } else {
                        return response()->json([
                            "status" => false,
                            'message' => 'No se encontraron archivos en la carpeta backup'
                        ]);
                    }
                }
            } else {
                return response()->json(["status" => false, 'message' => 'Error al ejecutar el backup'], 500);
            }



        } catch (\Exception $e) {
            return response()->json(["status" => false, 'mensaje' => 'Error al realizar el respaldo: ' . $e->getMessage()], 500);
        }
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            // query
            $data = Backuphistory::select(
                'historial_backups.id',
                'historial_backups.estado',
                'historial_backups.nombre AS namezip',
                'u.nombres',
                DB::raw("CONCAT(u.apellido_pa,' ', u.apellido_ma) AS apellidos"),
                DB::raw("DATE_FORMAT(historial_backups.created_at, '%M %e, %Y') AS fechcreacion"),
                DB::raw("DATE_FORMAT(historial_backups.created_at, '%H:%i:%s') AS hora_registro")
            )
                ->join('administradores AS a', 'historial_backups.administrator_id', '=', 'a.id')
                ->join('usuarios AS u', 'a.user_id', '=', 'u.id')
                ->orderBy('historial_backups.created_at', 'ASC')
                ->get();
            // datatable
            // return DataTables::of($data)
            //     ->addIndexColumn()
            //     ->make(true);
            return  response()->json(["status" => true, "data" => $data]);
        }

        return  response()->json(["status" => false, "mensaje" => 'Error: no se pueden cargar los archivos']);
    }

    public function DownloadBaseDatos($archivozip)
    {


        $ruta = 'SGAHUANUCO/' . $archivozip;
        $file = storage_path('app/' . $ruta);

        if (file_exists($file)) {

            return response()->download($file);
        } else {
            return response()->json(['error' => 'Archivo del solictante no encontrado'], 404);
        }
    }
}
