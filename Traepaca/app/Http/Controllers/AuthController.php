<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('correo', 'contraseña');
    
        if (
            Auth::attempt([
                'Correo' => $credentials['correo'], // con C mayúscula (igual que la BD)
                'password' => $credentials['contraseña'], // este es el valor que bcrypt validará
                
            ])
            
        ) {
            return redirect()->route('paginaprincipal');
        }
    
        return back()->withErrors(['correo' => 'Usuario o contraseña incorrectos']);
    }
    
    
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:500',
            'edad' => 'required|numeric|min:1|max:120',
            'correo' => 'required|email|unique:Usuarios,Correo',
            'contraseña' => 'required|string|min:8',
        ]);
    
        $user = User::create([
            'Nombre' => $request->nombre,
            'Apellidos' => $request->apellidos,
            'Edad' => $request->edad,
            'Correo' => $request->correo,
            'Contraseña' => bcrypt($request->contraseña),
            'Monedas' => 500,
            'Administrador' => 0,
        ]);
        
        
    
        Auth::login($user);
    
        return redirect()->route('paginaprincipal');
    }
    


}


?>