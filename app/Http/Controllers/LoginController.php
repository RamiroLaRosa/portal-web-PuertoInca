<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }

        return view('login');
    }

    public function authenticate(Request $request)
    {

        $request->validate([
            'codigo'   => ['required'],
            'password' => ['required'],
        ], [
            'codigo.required'   => 'Ingrese su código de usuario.',
            'password.required' => 'Ingrese su contraseña.',
        ]);

        $credentials = $request->only('codigo', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard.index')
                ->with('success', 'Bienvenido al sistema.');
        }

        return back()
            ->withErrors([
                'login' => 'Las credenciales no son válidas.',
            ])
            ->withInput();
    }
}
