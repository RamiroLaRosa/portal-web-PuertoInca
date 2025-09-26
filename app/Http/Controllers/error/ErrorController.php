<?php

namespace App\Http\Controllers\error;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function error403()
    {
        return view('error.page-error-403');
    }

    public function inactivoModuloTramite()
    {
        return view('error.page-inactivo_tramites');
    }
}
