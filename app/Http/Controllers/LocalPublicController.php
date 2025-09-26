<?php

// app/Http/Controllers/LocalPublicController.php
namespace App\Http\Controllers;

use App\Models\Local;

class LocalPublicController extends Controller
{
    public function index()
    {
        // Tomamos el primer local activo (ajusta si tendrás varios)
        $local = Local::where('is_active', 1)->orderBy('id')->first();

        return view('nosotros.locales', compact('local'));
    }
}
