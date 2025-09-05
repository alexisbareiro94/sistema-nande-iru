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
use App\Models\MovimientoCaja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

        //users
        Route::get('/api/users', [UserController::class, 'index'])->name('user.index');
        Route::post('/api/users', [UserController::class, 'store'])->name('user.store');

        //venta
        Route::post('/api/venta', [VentaController::class, 'store'])->name('venta.store');

        //movimiento
        Route::get('/api/movimiento', [MovimientoCajaController::class, 'index'])->name('movimiento.index');
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
    dd(session("$nombre"), gettype(session("$nombre")));
});

Route::get('/borrar-session', function () {
    session()->flush();
});

Route::get('/debug', function () {
     $carrito['465s7da'] = [
        '2' => [          
            'nombre' => 'tal cosa',
            //demas datos
        ],
        '5' => [
            'nombre' => 'otra cosa'
            //demas datos
        ]
    ];


    session(['prueba' => $carrito]);
});
