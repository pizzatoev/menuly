<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Admin');
    }

    /**
     * Muestra la lista de productos filtrada por id_carrito
     */
    public function index()
    {
        $user = auth()->user();
        return Producto::where('id_carrito', $user->id_carrito)->get();
    }

    /**
     * Guarda un nuevo producto desde el formulario AJAX.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria' => 'required|integer|in:1,2,3',
        ]);

        $user = auth()->user();

        Producto::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'id_carrito' => $user->id_carrito,
            'categoria' => $request->categoria,
        ]);

        return response()->json(['success' => true], 201);
    }

    /**
     * Elimina un producto desde la tabla con AJAX.
     */
    public function destroy(Producto $producto)
    {
        // Verificar que el producto pertenece al carrito del usuario
        if ($producto->id_carrito !== auth()->user()->id_carrito) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $producto->delete();
        return response()->json(['success' => true], 200);
    }

    /**
     * Actualiza un producto existente
     */
    public function update(Request $request, Producto $producto)
    {
        // Verificar que el producto pertenece al carrito del usuario
        if ($producto->id_carrito !== auth()->user()->id_carrito) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria' => 'required|integer|in:1,2,3',
        ]);

        $producto->update($request->only('nombre', 'precio', 'stock', 'categoria'));

        return response()->json(['success' => true]);
    }

    // Métodos no implementados
    public function create() { return response()->json(['message' => 'Método no implementado'], 501); }
    public function show(Producto $producto) 
    { 
        // Verificar que el producto pertenece al carrito del usuario
        if ($producto->id_carrito !== auth()->user()->id_carrito) {
            return response()->json(['error' => 'No autorizado'], 403);
        }
        return response()->json($producto); 
    }
    public function edit(Producto $producto) { return response()->json(['message' => 'Método no implementado'], 501); }
}
