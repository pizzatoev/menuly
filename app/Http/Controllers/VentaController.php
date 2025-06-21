<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin,Cajero']);
    }

    /**
     * Muestra la lista de ventas
     */
    public function index()
    {
        $user = Auth::user();
        $ventas = Venta::with('cliente')
                      ->whereHas('detalles.producto', function($query) use ($user) {
                          $query->where('id_carrito', $user->id_carrito);
                      })
                      ->orderBy('fecha', 'desc')
                      ->get();

        $userIds = Usuario::where('id_carrito', $user->id_carrito)->pluck('id_usuario');
        $clientes = Cliente::whereIn('id_usuario', $userIds)->get();

        $productos = Producto::where('id_carrito', $user->id_carrito)->get();

        return view('secciones.ventas', compact('ventas', 'clientes', 'productos'));
    }

    /**
     * Muestra el detalle de una venta específica
     */
    public function show($id)
    {
        $user = Auth::user();
        $venta = Venta::with(['detalles.producto', 'cliente'])
                     ->whereHas('detalles.producto', function($query) use ($user) {
                         $query->where('id_carrito', $user->id_carrito);
                     })
                     ->findOrFail($id);

        return view('secciones.detalle_venta', compact('venta'));
    }

    /**
     * Registra una nueva venta
     */
    public function store(Request $request)
    {
        $request->validate([
            'ci_cliente' => 'required|exists:cliente,ci',
            'tipo_pedido' => 'required|string',
            'metodo_pago' => 'required|string',
            'productos' => 'required|array',
            'productos.*.id_producto' => 'required|exists:producto,id_producto',
            'productos.*.cantidad' => 'required|integer|min:1'
        ]);

        $user = Auth::user();

        try {
            DB::beginTransaction();

            // Crear la venta
            $venta = Venta::create([
                'fecha' => now(),
                'tipo_pedido' => $request->tipo_pedido,
                'metodo_pago' => $request->metodo_pago,
                'ci_cliente' => $request->ci_cliente
            ]);

            $total = 0;

            // Registrar los detalles de la venta
            foreach ($request->productos as $item) {
                $producto = Producto::where('id_carrito', $user->id_carrito)
                                  ->findOrFail($item['id_producto']);

                if ($producto->stock < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para {$producto->nombre}");
                }

                $subtotal = $producto->precio * $item['cantidad'];
                $total += $subtotal;

                DetalleVenta::create([
                    'id_venta' => $venta->id_venta,
                    'id_producto' => $item['id_producto'],
                    'cantidad' => $item['cantidad'],
                    'subtotal' => $subtotal
                ]);

                // Actualizar stock
                $producto->stock -= $item['cantidad'];
                $producto->save();
            }

            // Actualizar el total de la venta
            $venta->total = $total;
            $venta->save();

            DB::commit();
            return response()->json(['success' => true, 'venta' => $venta]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}
