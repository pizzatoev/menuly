<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin,Cajero']);
    }

    /**
     * Muestra la lista de clientes del carrito actual
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Encontrar todos los IDs de usuario que pertenecen al mismo carrito
        $userIds = Usuario::where('id_carrito', $user->id_carrito)->pluck('id_usuario');

        // 2. Obtener todos los clientes registrados por esos usuarios
        $clientes = Cliente::whereIn('id_usuario', $userIds)->get();

        return view('secciones.clientes', [
            'clientes' => $clientes
        ]);
    }

    /**
     * Guarda un nuevo cliente
     */
    public function store(Request $request)
    {
        $request->validate([
            'ci' => 'required|string|max:20|unique:cliente,ci',
            'nombre' => 'required|string|max:100',
            'celular' => 'required|string|max:20',
            'direccion' => 'required|string|max:255'
        ]);

        Cliente::create([
            'ci' => $request->ci,
            'nombre' => $request->nombre,
            'celular' => $request->celular,
            'direccion' => $request->direccion,
            'id_usuario' => Auth::id()
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Actualiza un cliente existente
     */
    public function update(Request $request, Cliente $cliente)
    {
        // Opcional: Verificar que el cliente que se edita pertenezca al carrito del usuario
        $user = Auth::user();
        $userIds = Usuario::where('id_carrito', $user->id_carrito)->pluck('id_usuario');
        if (!in_array($cliente->id_usuario, $userIds->toArray())) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'celular' => 'required|string|max:20',
            'direccion' => 'required|string|max:255'
        ]);

        $cliente->update($validatedData);

        return response()->json(['success' => true]);
    }

    /**
     * Elimina un cliente
     */
    public function destroy(Cliente $cliente)
    {
        // Opcional: Verificar que el cliente que se elimina pertenezca al carrito del usuario
        $user = Auth::user();
        $userIds = Usuario::where('id_carrito', $user->id_carrito)->pluck('id_usuario');
        if (!in_array($cliente->id_usuario, $userIds->toArray())) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
        }

        try {
            $cliente->delete();
            return response()->json(['success' => true]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Manejar error de clave foránea (si el cliente tiene ventas)
            return response()->json([
                'success' => false, 
                'message' => 'No se puede eliminar el cliente porque tiene ventas asociadas.'
            ], 409);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el cliente.'], 500);
        }
    }
} 