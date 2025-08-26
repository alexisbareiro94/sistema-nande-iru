<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DistribuidorController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProductoController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Models\Producto;

Route::get('/login', [AuthController::class, 'login_view'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'register_view'])->name('register.view');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('home.index');
    })->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/caja', [CajaController::class, 'index_view'])->name('caja.index');
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
