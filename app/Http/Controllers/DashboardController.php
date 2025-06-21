<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Producto;
use App\Models\Usuario;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\TransaccionController;
use App\Models\Venta;
use App\Models\Transaccion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Muestra la vista principal del panel de administración
     */
    public function index()
    {
        Log::info('Accediendo al dashboard. Usuario autenticado: ' . (Auth::check() ? 'Sí' : 'No'));
        if (Auth::check()) {
            Log::info('Usuario actual: ' . Auth::user()->correo);
        }
        return view('dashboard');
    }

    /**
     * Devuelve las estadísticas para el dashboard principal.
     */
    public function estadisticas()
    {
        $user = Auth::user();
        $idCarrito = $user->id_carrito;

        // --- VENTAS ---
        $ventasHoyQuery = Venta::whereHas('detalles.producto', function($query) use ($idCarrito) {
            $query->where('id_carrito', $idCarrito);
        })->whereDate('fecha', Carbon::today());

        $ventasDineroHoy = $ventasHoyQuery->sum('total');
        $cantidadVentasHoy = $ventasHoyQuery->count();

        $ventasMes = Venta::whereHas('detalles.producto', function($query) use ($idCarrito) {
            $query->where('id_carrito', $idCarrito);
        })->whereYear('fecha', Carbon::today()->year)
          ->whereMonth('fecha', Carbon::today()->month)
          ->sum('total');

        // --- CLIENTES NUEVOS ---
        $firstPurchases = DB::table('venta as v')
            ->join('detalle_venta as dv', 'v.id_venta', '=', 'dv.id_venta')
            ->join('producto as p', 'dv.id_producto', '=', 'p.id_producto')
            ->where('p.id_carrito', $idCarrito)
            ->select('v.ci_cliente', DB::raw('MIN(v.fecha) as first_purchase_date'))
            ->groupBy('v.ci_cliente')
            ->get();

        $clientesNuevos = $firstPurchases->filter(function($row) {
            return Carbon::parse($row->first_purchase_date)->isToday();
        })->count();

        // --- GASTOS ---
        $gastosHoy = Transaccion::where('id_carrito', $idCarrito)
                               ->whereDate('fecha', Carbon::today())
                               ->sum('monto');

        // --- PRODUCTOS ---
        $productosStock = Producto::where('id_carrito', $idCarrito)->sum('stock');

        // --- PRODUCTOS BAJO STOCK (EXTRA) ---
        $productosBajoStock = Producto::where('id_carrito', $idCarrito)
                                      ->where('stock', '<', 10) // Asumimos que bajo stock es menos de 10
                                      ->get(['nombre', 'stock']);


        return response()->json([
            'ventasHoy' => number_format($ventasDineroHoy, 2),
            'cantidadVentas' => $cantidadVentasHoy,
            'clientesNuevos' => $clientesNuevos,
            'gastosHoy' => number_format($gastosHoy, 2),
            'ventasMes' => number_format($ventasMes, 2),
            'totalProductos' => $productosStock,
            'productosBajoStock' => $productosBajoStock
        ]);
    }

    /**
     * Carga dinámicamente una sección del dashboard por AJAX
     */
    public function cargarSeccion(Request $request, $nombre)
    {
        $user = Auth::user();

        // 1. Verificar permisos
        if ($nombre === 'productos' && $user->rol !== 'Admin') {
            return response('No tienes permiso para ver esta sección.', 403);
        }

        // 2. Verificar que la vista exista
        if (!view()->exists("secciones.$nombre")) {
            return response("Sección no encontrada: secciones.{$nombre}", 404);
        }

        // 3. Cargar el controlador o la vista correspondiente
        switch ($nombre) {
            case 'productos':
                $productos = Producto::where('id_carrito', $user->id_carrito)->get();
                return view('secciones.productos', ['productos' => $productos]);
            
            case 'ventas':
                return app(VentaController::class)->index();
            
            case 'clientes':
                return app(ClienteController::class)->index();

            case 'transacciones':
                return app(TransaccionController::class)->index();

            case 'detalle_venta':
                if (!$request->has('id')) {
                    return response('ID de venta no especificado.', 400);
                }
                return app(VentaController::class)->show($request->input('id'));
            
            default:
                // Por si se agrega una sección nueva sin lógica específica
                return view("secciones.$nombre");
        }
    }
}
