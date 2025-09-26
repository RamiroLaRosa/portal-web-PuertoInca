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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class AdministratorController extends Controller
{
    public function verManualAdmin()
    {
        $file = storage_path('app/public/manuales/usuario_admin.pdf');
        
        if (file_exists($file)) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);

            // Verificar la extensión y establecer el tipo de contenido correspondiente
            switch ($extension) {
                case 'pdf':
                    $contentType = 'application/pdf';
                    break;
                case 'png':
                    $contentType = 'image/png';
                    break;
                case 'jpg':
                case 'jpeg':
                    $contentType = 'image/jpeg';
                    break;
                default:
                    abort(404, 'Formato de archivo no admitido.');
            }

            $headers = [
                'Content-Type' => $contentType,
            ];

            $fileTitle = 'contract.' . $extension;
            return response()->download($file, $fileTitle, $headers, 'inline');
        } else {
            abort(404, 'Archivo no encontrado!');
        }
    }

    public function verManualUsers()
    {
        $file = storage_path('app/public/manuales/usuario_normal.pdf');
        
        if (file_exists($file)) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);

            // Verificar la extensión y establecer el tipo de contenido correspondiente
            switch ($extension) {
                case 'pdf':
                    $contentType = 'application/pdf';
                    break;
                case 'png':
                    $contentType = 'image/png';
                    break;
                case 'jpg':
                case 'jpeg':
                    $contentType = 'image/jpeg';
                    break;
                default:
                    abort(404, 'Formato de archivo no admitido.');
            }

            $headers = [
                'Content-Type' => $contentType,
            ];

            $fileTitle = 'contract.' . $extension;
            return response()->download($file, $fileTitle, $headers, 'inline');
        } else {
            abort(404, 'Archivo no encontrado!');
        }
    }
}
