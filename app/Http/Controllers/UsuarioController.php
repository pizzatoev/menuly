<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function registrar(Request $request)
    {
        // Validar los datos que llegan del formulario
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuario,correo',
            'contrasena' => 'required|string|min:6',
            'rol' => 'required|string',
            'id_carrito' => 'required|integer|exists:carrito,id_carrito',
        ]);

        // Crear el usuario en la base de datos
        Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'contrasena' => Hash::make($request->contrasena), // Encriptar la contraseña
            'rol' => $request->rol,
            'id_carrito' => $request->id_carrito,
        ]);

        // Redirigir con mensaje opcional
        return redirect('/')->with('success', 'Usuario registrado con éxito.');
    }
}
