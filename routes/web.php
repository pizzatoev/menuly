<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\TransaccionController;
use App\Http\Controllers\ClienteController;

// Rutas públicas
Route::get('/', function () {
    return view('menuly');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.view');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/registrar-usuario', [UsuarioController::class, 'registrar'])->name('registrar.usuario');

// Rutas protegidas por autenticación
Route::middleware(['web', 'auth'])->group(function () {

    // Dashboard principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/estadisticas-dashboard', [DashboardController::class, 'estadisticas'])->name('dashboard.estadisticas');

    // Rutas para cargar secciones dinámicamente
    Route::get('/seccion/{nombre}', [DashboardController::class, 'cargarSeccion'])->name('seccion.cargar');

    // Sección de transacciones solo Admin
    Route::get('/seccion/transacciones', function() {
        if (auth()->user()->rol !== 'Admin') {
            abort(403, 'Acceso denegado');
        }

        $transacciones = DB::table('transacciones')
            ->where('id_carrito', auth()->user()->id_carrito)
            ->orderBy('fecha', 'desc')
            ->get();

        return view('transacciones', compact('transacciones'));
    });

    // Rutas para Administradores
    Route::middleware(['role:Admin'])->group(function () {
        // CRUD de productos
        Route::resource('productos', ProductoController::class)->except(['show', 'edit', 'create']);

        // CRUD de transacciones (Admin vía funciones directas)
        Route::post('/transacciones', function(Request $request) {
            try {
                DB::table('transacciones')->insert([
                    'id_carrito' => auth()->user()->id_carrito,
                    'descripcion' => $request->descripcion,
                    'monto' => $request->monto,
                    'fecha' => $request->fecha,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                return response()->json(['success' => true, 'message' => 'Transacción registrada correctamente']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Error al registrar la transacción']);
            }
        });

        Route::delete('/transacciones/{id}', function($id) {
            try {
                $deleted = DB::table('transacciones')
                    ->where('id_gasto', $id)
                    ->where('id_carrito', auth()->user()->id_carrito)
                    ->delete();

                if ($deleted) {
                    return response()->json(['success' => true, 'message' => 'Transacción eliminada correctamente']);
                } else {
                    return response()->json(['success' => false, 'message' => 'Transacción no encontrada']);
                }
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Error al eliminar la transacción']);
            }
        });
    });

    // Rutas compartidas Admin y Cajero
    Route::middleware(['role:Admin,Cajero'])->group(function () {
        // Ventas
        Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
        Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');
        Route::get('/ventas/{venta}', [VentaController::class, 'show'])->name('ventas.show');

        // Clientes
        Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
        Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
        Route::put('/clientes/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');
        Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

        // Transacciones con controlador (si deseas mantenerlo además del inline)
        Route::get('/transacciones', [TransaccionController::class, 'index'])->name('transacciones.index');
        Route::post('/transacciones', [TransaccionController::class, 'store'])->name('transacciones.store');
        Route::delete('/transacciones/{transaccion}', [TransaccionController::class, 'destroy'])->name('transacciones.destroy');
    });
});
