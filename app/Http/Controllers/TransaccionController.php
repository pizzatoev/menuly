<?php

namespace App\Http\Controllers;

use App\Models\Transaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaccionController extends Controller
{
    /**
     * Muestra la lista de transacciones
     */
    public function index()
    {
        $user = Auth::user();
        $transacciones = Transaccion::where('id_carrito', $user->id_carrito)
                                   ->orderBy('fecha', 'desc')
                                   ->get();

        return view('secciones.transacciones', [
            'transacciones' => $transacciones
        ]);
    }

    /**
     * Guarda una nueva transacción
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date'
        ]);

        $user = Auth::user();

        Transaccion::create([
            'descripcion' => $request->descripcion,
            'monto' => $request->monto,
            'fecha' => $request->fecha,
            'id_carrito' => $user->id_carrito
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Elimina una transacción
     */
    public function destroy(Transaccion $transaccion)
    {
        // Verificar que la transacción pertenece al carrito del usuario
        if ($transaccion->id_carrito !== Auth::user()->id_carrito) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $transaccion->delete();
        return response()->json(['success' => true]);
    }
} 