<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    //Aquí se muestra el formulario de login
    public function create()
    {
        return view('auth.login');
    }
    public function store(Request $request)
    {
        //Se validan los datos
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        //Se autentica al usuario
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        //Si se falla la autenticación, se muestra un error
        return back()->withErrors([
            'email' => '¡Los datos ingresados no coinciden! Intenta de nuevo.',
        ])->onlyInput('email');
    }
    //Función para manejar el logout
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
