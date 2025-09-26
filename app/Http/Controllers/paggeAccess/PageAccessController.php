<?php

namespace App\Http\Controllers\paggeAccess;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Carbon;

class PageAccessController extends Controller
{
    public function index()
    {
        return view('inscripciones.index');
    }

    public function estadomodulo()
    {

        try {
            // $result = Admission::select('estado')
            // ->orderBy('id', 'desc')
            // ->limit(1) // Ordena en orden descendente por 'id'
            // ->get();

            // if ($result->count() > 0) {
            //     if($result[0]->estado === 1){
            //         $estado = true;
            //     }else{
            //         $estado= false;
            //     }
            //     return  $estado;
            // } else {
            //     return  false;
            // }
            return false;

        } catch (Exception $e) {

            return $e;

        }

    }
    public function estadomodulotramitedocumentario()
    {

        try {

            // $diaNumero = Carbon::now()->dayOfWeek;

            // if ($diaNumero >= 0 && $diaNumero <= 6) {
                // Obtén la hora actual del servidor
                $horaActualSrv = Carbon::now();
                $horaRestada = $horaActualSrv->subHours(5);
                $horaActual = $horaRestada->format('H:i:s');


                // Define el rango permitido de acceso (8:30 am - 6:30 pm)
                $horaInicio = Carbon::parse('8:30:00')->format('H:i:s');
                $horaFin = Carbon::parse('23:50:00')->format('H:i:s');

                // Verifica si la hora actual está dentro del rango permitido
                if ($horaActual >= $horaInicio && $horaActual <= $horaFin) {
                    return true;
                } else {
                    return false;
                }
            // } else {
            //     return false;
            // }

        } catch (Exception $e) {

            return $e;

        }

    }

}
