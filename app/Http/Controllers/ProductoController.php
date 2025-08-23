<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Distribuidor;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\StoreProductRequest;

class ProductoController extends Controller
{
    //public function __construct() {}

    public function index()
    {
        return view('productos.index', [
            'productos' => Producto::all(),
            'categorias' => Categoria::all(),
            'marcas' => Marca::all(),
            'distribuidores' => Distribuidor::all(),
        ]);
    }

    //function para hacer un buscador dinámico con js
    public function search(Request $request)
    {
        $search = $request->query('q');
        $filtro = $request->query('filtro');

        $query = Producto::query();
        if ($filtro == "nombre") {
            $query->whereLike("nombre", "%$search%");
        }

        if ($filtro == "tipo") {
            $query->whereLike("tipo", "%$search%");
        }

        if ($filtro == "categoria") {
            $query->whereHas('categoria', function ($q) use ($search) {
                $q->whereLike('nombre', "%$search%");
            });
        }

        if ($filtro == "marca") {
            $query->whereHas('marca', function ($q) use ($search) {
                $q->whereLike('nombre', "%$search%");
            });
        }

        if (empty($filtro)) {
            $query->whereLike("nombre", "%$search%")
                ->orWhereLike("codigo", "%$search%");
        }

        return response()->json([
            'success' => true,
            'productos' => $query->with(['marca', 'distribuidor'])->get(),
        ]);
    }

    //function para actualizar la lista dinámicamente el <select> con js
    public function all()
    {
        return response()->json([
            'marcas' => Marca::all(),
            'categorias' => Categoria::all(),
            'distribuidores' => Distribuidor::all(),
        ]);
    }

    public function allProducts(){{ 
        return response()->json([
            'success' => true,
            'productos' => Producto::with(['marca', 'distribuidor', 'categoria'])->get(),
        ]);
     }}

    public function add_producto_view()
    {
        return view('productos.add-producto', [
            'marcas' => Marca::all(),
            'categorias' => Categoria::all(),
            'distribuidores' => Distribuidor::all(),
        ]);
    }

    public function store(StoreProductRequest $request)
    {
     //   return response()->json($request);
        $data = $request->validated();

        if ($request->hasFile('imagen')) {
            $fileName = time() . '.' . $request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move(public_path('images'), $fileName);

            $data['imagen'] = $fileName;
        }
        $request->marca_id ?? $data['marca_id'] = 1;
        $request->categoria_id ?? $data['categoria_id'] = 1;
        $request->distribuidor_id ?? $data['distribuidor_id'] = 1;

        try {
            $producto = Producto::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Producto agregado correctamente.',
                'producto' => $producto,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function update_view(string $id)
    {
        return view('productos.edit', [
            'producto' => Producto::find($id),
            'marcas' => Marca::all(),
            'categorias' => Categoria::all(),
            'distribuidores' => Distribuidor::all(),
        ]);
    }

    public function update(UpdateProductRequest $request, string $id)
    {                            
        $data = $request->validated();        
       
        try {
            $producto = Producto::find($id);            
            if ($request->hasFile('imagen')) {
                if (file_exists(public_path("images/$producto->imagen")) && $producto->imagen) {                    
                    unlink(public_path("images/$producto->imagen"));
                }
                $fileName = time() . '.' . $request->file('imagen')->getClientOriginalExtension();
                $request->file('imagen')->move(public_path('images'), $fileName);
                $data['imagen'] = $fileName;
            }
            if ($request->eliminar_imagen == "true" && $producto->imagen) {                
                  if (file_exists(public_path("images/$producto->imagen"))) {
                    unlink(public_path("images/$producto->imagen"));
                }
                $data['imagen'] = null;
            }                        
            $producto->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Producto Actualizado',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,                
                'errors' => $e->getMessage(),
            ], 400);
        }
    }

    public function delete(string $id){        
        try{
            $producto = Producto::find($id);
            $producto->delete();

            return response()->json([
                'success' => true,
                'message' => "producto borrado",
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage(),
            ]);
        }
    }
}
