<?php

use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteDistController;
use App\Http\Controllers\DistribuidorController;
use App\Http\Controllers\GestionUsersController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\MovimientoCajaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\NotificacionController;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CajaMiddleware;
use Illuminate\Support\Facades\Route;

use App\Models\{Auditoria, MovimientoCaja, User, Venta, DetalleVenta, Caja, Pago, Producto, PagoSalario};
use Carbon\Carbon;

Route::get('/login', [AuthController::class, 'login_view'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('throttle:5,1');
Route::get('/register', [AuthController::class, 'register_view'])->name('register.view');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('home');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/download', function(){
        return response()->download(public_path("reports/report.pdf"));
    });

    Route::middleware(CajaMiddleware::class)->group(function () {
        //caja
        Route::get('/caja', [CajaController::class, 'index_view'])->name('caja.index');
        Route::post('/abrir-caja', [CajaController::class, 'abrir'])->name('caja.abrir');
        Route::post('/caja', [CajaController::class, 'update'])->name('caja.update');

        //cajas anteriores
        Route::get('/caja/anteriores', [CajaController::class, 'anteriores'])->name('caja.anteriores');
        Route::get('api/caja/{id}', [CajaController::class, 'show'])->name('caja.show');

        //users
        Route::get('/api/users', [UserController::class, 'index'])->name('user.index');
        Route::post('/api/users', [UserController::class, 'store'])->name('user.store');

        //venta
        Route::post('/api/venta', [VentaController::class, 'store'])->name('venta.store');
        Route::get('/movimientos', [VentaController::class, 'index_view'])->name('venta.index.view');
        Route::get('/venta/{codigo}', [VentaController::class, 'show']);
        Route::get('/venta', [VentaController::class, 'index']);
        //exportaciones
        Route::get('/export-excel', [VentaController::class, 'export_excel'])->name('venta.excel');
        Route::get('/export-pdf', [VentaController::class, 'export_pdf'])->name('venta.pdf');

        //movimiento
        Route::get('/api/movimiento', [MovimientoCajaController::class, 'index'])->name('movimiento.index');
        Route::get('/api/movimiento/total', [MovimientoCajaController::class, 'total'])->name('movimiento.total');
        Route::post('/api/movimiento', [MovimientoCajaController::class, 'store'])->name('movimiento.store');
        Route::get('/api/movimientos/charts_caja', [MovimientoCajaController::class, 'charts_caja']);
        Route::get('/api/productos', [ProductoController::class, 'search'])->name('productos.search');
    });

    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/inventario', [ProductoController::class, 'index'])->name('producto.index');
        Route::get('/agregar-producto', [ProductoController::class, 'add_producto_view'])->name('producto.add');
        Route::post('/agregar-producto', [ProductoController::class, 'store'])->name('producto.store');
        Route::get('/edit/{id}/producto', [ProductoController::class, 'update_view'])->name('producto.update.view');
        Route::post('/edit/{id}/producto', [ProductoController::class, 'update'])->name('producto.update');
        Route::get('/api/all', [ProductoController::class, 'all'])->name('producto.all'); //mal nombrado pero bueno
        Route::get('/api/all-products', [ProductoController::class, 'allProducts'])->name('productos.all.products');
        Route::delete('/api/delete/{id}/producto', [ProductoController::class, 'delete'])->name('producto.delete');
        Route::get('/api/producto/{id}', [ProductoController::class, 'show'])->name('producto.show');
        Route::post('/api/import-products', [ProductoController::class, 'import_excel']);

        Route::post('/agregar-categoria', [CategoriaController::class, 'store'])->name('categoria.store');
        Route::get('/api/categorias', [CategoriaController::class, 'index'])->name('categorias.index');

        Route::post('/agregar-distribuidor', [DistribuidorController::class, 'store'])->name('distribuidor.store');
        Route::get('/api/distribuidores', [DistribuidorController::class, 'index'])->name('distribuidor.index');

        Route::post('/agregar-marca', [MarcaController::class, 'store'])->name('marca.store');
        Route::get('/api/marcas', [MarcaController::class, 'index'])->name('marca.all');

        Route::get('/reportes', [ReporteController::class, 'index'])->name('reporte.index');
        Route::get('/api/pagos/{periodo}', [ReporteController::class, 'tipos_pagos']);
        Route::get('/api/ventas/{periodo}', [ReporteController::class, 'ventas_chart']);
        Route::get('/api/tipo_venta/{periodo}', [ReporteController::class, 'tipo_venta']);
        Route::get('/api/utilidad/{periodo}/{option?}', [ReporteController::class, 'tendencia']);
        Route::get('/api/tendencias/{periodo}', [ReporteController::class, 'gananacias']);
        Route::get('/api/egresos/{periodo}', [ReporteController::class, 'egresos']);
        Route::get('/api/egresos/concepto/{periodo}', [ReporteController::class, 'egresos_concepto']);

        Route::get('/gestion_usuarios', [GestionUsersController::class, 'index_view'])->name('gestion.index.view');
        Route::post('/gestion_usuarios', [GestionUsersController::class, 'store'])->name('gestion.users.store');

        Route::get('/top_ventas', [ProductoController::class, 'top_ventas'])->name('producto.top.ventas');

        Route::get('/api/notificaciones', [NotificacionController::class, 'index']);
        Route::put('/api/notificaciones/update/{id}', [NotificacionController::class, 'update']);

        Route::get('/api/user/{id}', [UserController::class, 'show']);
        Route::get('/api/gestion_users', [GestionUsersController::class, 'index']);
        Route::get('/api/gestion_user/{id}', [GestionUsersController::class, 'show']);
        Route::post('/api/gestion_user/{id}', [GestionUsersController::class, 'update']);
        Route::delete('/api/gestion_user/{id}', [GestionUsersController::class, 'delete']);

        Route::get('/api/auditorias', [GestionUsersController::class, 'refresh_auditorias']);   
        Route::get('/auditorias', [AuditoriaController::class, 'index'])->name('auditoria.index');
        
        Route::get('/gestion_clientes_distribuidores', [ClienteDistController::class, 'index'])->name('cliente.dist.index');

        Route::get('/api/cliente/{id}', [ClienteDistController::class, 'show_cliente']);
        Route::post('/api/user/{id}', [UserController::class, 'update']);

        Route::post('/api/cliente/{id}', [ClienteDistController::class, 'desactive']);
    });
});

Route::get('/session/{nombre}', function ($nombre) {
    return [session("$nombre"), gettype(session("$nombre"))];
    session()->forget($nombre);
});

Route::get('/borrar-session', function () {
    session()->forget('ventas');
});

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
Route::get('/test-mail', function () {
    try {
        Mail::raw('Este es un correo de prueba enviado desde Laravel con Gmail SMTP.', function ($message) {
            $message->to('ale.bareirolu@gmail.com')
                    ->subject('Correo de prueba desde Laravel');
        });

        return '✅ Correo enviado correctamente';
    } catch (\Exception $e) {
        return '❌ Error al enviar correo: ' . $e->getMessage();
    }
});
;
