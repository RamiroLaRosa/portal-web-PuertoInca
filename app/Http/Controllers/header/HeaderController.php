<?php

namespace App\Http\Controllers\header;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HeaderController extends Controller
{
    public function DataAreaAdm()
    {
        $userId = Auth::User()->id;

        $result = Administrator::join('usuarios as u', 'administradores.user_id', '=', 'u.id')
            ->join('roles as r', 'administradores.role_id', '=', 'r.id')
            ->join('td_areas as ar', 'r.tdarea_id', '=', 'ar.id')
            ->select(
                'ar.NOMBRE'
            )
            ->where('u.id', '=', $userId)
            ->get();

        return $result;
    }
}
