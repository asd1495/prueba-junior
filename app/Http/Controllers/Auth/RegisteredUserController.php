<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    //Se muestra el formulario de registro
    public function create()
    {
        return view('auth.register');
    }

    //Aquí se maneja la petición de registro
    public function store(Request $request)
    {
        //Se validan los datos
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        //Se crea un nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //Se autentica al usuario creado
        Auth::login($user);

        //Redirecciona al dashboard
        return redirect()->route('dashboard');
    }
}
