<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DistribuidorController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProductoController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Models\Producto;

Route::get('/login', [AuthController::class, 'login_view'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('home.index');
    })->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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

    Route::get('/prueba-code', function(){
        $categoria = App\Models\Categoria::select('nombre')->where('id', 2)->first();
        $marca = App\Models\Marca::select('nombre')->where('id', 4)->first();
        $nombre = 'cubierta 175/70R14';

        $splitMarca = collect(str_split($marca->nombre));

        if ($splitMarca->contains(' ')) {
            $spaceIndex = $splitMarca->search(fn($char) => $char === ' ');
            $code = $splitMarca->first() . $splitMarca[$spaceIndex + 1];
        } else {
            $code = $splitMarca->take(2)->implode('');
        }
        $cat = collect(str_split($categoria->nombre))->take(2)->implode('');
        if (preg_match('/\d/', $nombre)) {
            $resultado = preg_replace('/\D/', '', $nombre);
        } else {
            $resultado = preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚñÑ]/u', '', $nombre);
        }
        $realCode = $cat.$resultado.$code;
        $exists = App\Models\Producto::where('tipo', 'servicio')->get();
        $codePrueba = (string)strtolower($realCode);
        $proExists = \App\Models\Producto::where('codigo', $codePrueba)->first();
        if($exists && $proExists && $proExists->tipo == 'servicio'){
            $nro = count($exists);
            $nro += 1;
            $resultadodos = $resultado.$nro;
            $realCode = $cat.$resultadodos.$code;
        }

        if($proExists && $proExists->tipo == 'producto'){
            $chars = range(0, 100);
            $add =  collect($chars)->random(2)->implode('');
            $realCode = $cat.$resultado.$add.$code;
        }
        return strtolower($realCode);
    });
});
