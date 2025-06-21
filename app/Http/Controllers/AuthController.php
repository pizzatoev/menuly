<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        \Log::info('Intento de login para: ' . $request->correo);
        
        // Validar los campos requeridos
        $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required|string',
        ]);

        // Buscar el usuario por correo
        $user = Usuario::where('correo', $request->correo)->first();
        \Log::info('Usuario encontrado: ' . ($user ? 'Sí' : 'No'));

        if (!$user) {
            return back()->with('error', 'Correo no encontrado');
        }

        if (!Hash::check($request->contrasena, $user->contrasena)) {
            \Log::info('Contraseña incorrecta');
            return back()->with('error', 'Contraseña incorrecta');
        }

        // Iniciar sesión con remember
        Auth::login($user, true);
        \Log::info('Auth::login ejecutado. Auth::check(): ' . (Auth::check() ? 'true' : 'false'));
        \Log::info('ID de sesión: ' . session()->getId());

        if (Auth::check()) {
            \Log::info('Redirigiendo a dashboard...');
            return redirect()->intended(route('dashboard'));
        } else {
            \Log::error('Fallo en Auth::check después de login');
            return back()->with('error', 'No se pudo iniciar sesión (Auth::check falló)');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
