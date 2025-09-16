<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DistribuidorController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\MovimientoCajaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CajaMiddleware;
use Illuminate\Support\Facades\Route;

use App\Models\{MovimientoCaja, User, Venta, DetalleVenta, Caja, Pago, Producto};
use Illuminate\Support\Facades\Cache;

Route::get('/login', [AuthController::class, 'login_view'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'register_view'])->name('register.view');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('home.index');
    })->name('home');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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
    });

    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/inventario', [ProductoController::class, 'index'])->name('producto.index');
        Route::get('/agregar-producto', [ProductoController::class, 'add_producto_view'])->name('producto.add');
        Route::post('/agregar-producto', [ProductoController::class, 'store'])->name('producto.store');
        Route::get('/edit/{id}/producto', [ProductoController::class, 'update_view'])->name('producto.update.view');
        Route::post('/edit/{id}/producto', [ProductoController::class, 'update'])->name('producto.update');
        Route::get('/api/all', [ProductoController::class, 'all'])->name('producto.all'); //mal nombrado pero bueno xdxdxdxd
        Route::get('/api/productos', [ProductoController::class, 'search'])->name('productos.search');
        Route::get('/api/all-products', [ProductoController::class, 'allProducts'])->name('productos.all.products');
        Route::delete('/api/delete/{id}/producto', [ProductoController::class, 'delete'])->name('producto.delete');
        Route::get('/api/producto/{id}', [ProductoController::class, 'show'])->name('producto.show');

        Route::post('/agregar-categoria', [CategoriaController::class, 'store'])->name('categoria.store');
        Route::get('/api/categorias', [CategoriaController::class, 'index'])->name('categorias.index');

        Route::post('/agregar-distribuidor', [DistribuidorController::class, 'store'])->name('distribuidor.store');
        Route::get('/api/distribuidores', [DistribuidorController::class, 'index'])->name('distribuidor.index');

        Route::post('/agregar-marca', [MarcaController::class, 'store'])->name('marca.store');
        Route::get('/api/marcas', [MarcaController::class, 'index'])->name('marca.all');
    });
});

Route::get('/session/{nombre}', function ($nombre) {
    return [session("$nombre"), gettype(session("$nombre"))];
    session()->forget($nombre);
});

Route::get('/borrar-session', function () {
    session()->forget('ventas');
});



Route::get('/debug', function () {
    $caja = Caja::find(1);
    $mayoresVentas = Venta::where('caja_id', $caja->id)->orderBy('total', 'desc')->get()->take(3);
    $montoMayoresVentas = $mayoresVentas->sum('total');
    $transacciones = Venta::where('caja_id', $caja->id)->count();
    $clientes = Venta::where('caja_id', $caja->id)->get()->unique('cliente_id')->count();
    $efectivo = Venta::where('caja_id', $caja->id)->where('forma_pago', 'efectivo')->sum('total');
    $transferencia = Venta::where('caja_id', $caja->id)->where('forma_pago', 'transferencia')->sum('total');

    $total = $efectivo + $transferencia;
    $efecPorcentaje = round(((100 * $efectivo) / $total), 1);
    $transfProcentaje = round(((100 * $transferencia) / $total), 1);

      $ventas = DetalleVenta::where('caja_id', $caja->id)
                ->with('producto:id,nombre')
                ->get()
                ->groupBy('producto_id')
                ->map(function ($items) {
                    return [
                        'cantidad' => $items->sum('cantidad'),
                        'producto' => $items->first()->producto->nombre,
                        'total'    => $items->sum('total'),
                    ];
                })
                ->sortByDesc('total')   
                ->take(3)    ;
                

                dd($ventas->values()->toArray());
    $ventasOrdenadas = collect($ventas)->sortDesc()->toArray();   
    dd($ventasOrdenadas);
   
});
