<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class ApinetpeController extends Controller
{
    public function query_data($nroidenti)
    {
        $token = 'apis-token-6194.hK3hbzBDyBDl6XqMq1idxOEs8zNDv6AJ';

        // Iniciar llamada a API
        $curl = curl_init();

        // Buscar ruc sunat
        curl_setopt_array($curl, array(
        // para usar la versión 2
        CURLOPT_URL => 'https://api.apis.net.pe/v2/reniec/dni?numero=' . $nroidenti,
        // para usar la versión 1
        // CURLOPT_URL => 'https://api.apis.net.pe/v1/ruc?numero=' . $ruc,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Referer: http://apis.net.pe/api-ruc',
            'Authorization: Bearer ' . $token
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        

        return response()->json([
                    "status" => true,
                    "mensaje" => 'Consulta realizada',
                    "data" =>$response
                ]);
    }
}
