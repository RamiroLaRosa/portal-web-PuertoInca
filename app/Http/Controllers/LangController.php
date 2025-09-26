<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;

class LangController extends Controller
{
    public function change(Request $request, $lang)
    {

        $availableLocales = ['en', 'es', 'qu'];
        if (in_array($lang, $availableLocales)) {
            app()->setLocale($lang);
            session(['locale' => $lang]);
        } else {
            app()->setLocale('en'); 
        }

        return Redirect::back();
    }
}
