<?php

namespace App\Http\Controllers;

use App\Events\AuditoriaCreadaEvent;
use App\Imports\ProductosImport;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Distribuidor;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Models\Auditoria;
use App\Services\ProductService;
use Maatwebsite\Excel\Facades\Excel;

class ProductoController extends Controller
{
    public function __construct(protected ProductService $productService) {}

    public function index()
    {
        $query = Producto::query();
        $productos = $query->get();
        $total = count($productos);
        $totalServicios = count($productos->where('tipo', 'servicio'));
        $totalProductos = count($productos->where('tipo', 'producto'));
        $stock = count(Producto::where('tipo', 'producto')->whereColumn('stock_minimo', '>=', 'stock')->where('stock', '!=', 0)->get());
        $sinStock = count(Producto::where('stock', 0)->get());

        return view('productos.index', [
            'productos' => $query->orderBy('id', 'desc')->paginate(15),
            'stock' => $stock,
            'total' => $total,
            'sinStock' => $sinStock,
            'totalProductos' => $totalProductos,
            'totalServicios' => $totalServicios,
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
        $orderBy = $request->query('orderBy');
        $direction = $request->query('dir');
        $filter = $request->query('filter');
        $query = Producto::query();

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

        if (filled($orderBy) && filled($direction)) {
            $query->orderBy($orderBy, $direction);
        }

        if (filled($filter)) {
            if ($filter == 'sin_stock') {
                $query->where('stock', 0);
            } elseif ($filter == 'stock_min') {
                $query->whereColumn('stock_minimo', '>=', 'stock')->where('stock', '!=', 0);
            } elseif ($filter == 'total_productos') {
                $query;
            } elseif ($filter == 'servicios') {
                $query->where('tipo', 'servicio');
            } else {
                $query->where('tipo', 'producto');
            }
        }

        if (!filled($filtro) && filled($search)) {
            $query->whereLike("nombre", "%$search%")
                ->orWhereLike("codigo", "%$search%");
        }
        $productos = $query->with(['marca', 'distribuidor'])
            ->get();

        return response()->json([
            'success' => true,
            'productos' => $productos,
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

    public function allProducts()
    {
        return response()->json([
            'success' => true,
            'productos' => Producto::with(['marca', 'distribuidor', 'categoria'])->orderByDesc('created_at')->get(),
        ]);
    }

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
            if ($request->codigo_auto) {
                $data['codigo'] = $this->productService->create_code($data['categoria_id'], $data['nombre'], $data['marca_id']);
            }            
            $producto = Producto::create($data);
            // return response()->json('punto 4');
            Auditoria::create([
                'created_by' => auth()->user()->id,
                'entidad_type' => Producto::class,
                'entidad_id' => $producto->id,
                'accion' => 'Creación de producto'
            ]);         
            AuditoriaCreadaEvent::dispatch(tenant_id());
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
    public function show(string $id)
    {
        try {
            return response()->json([
                'success' => true,
                'producto' => Producto::select('id', 'nombre')->where('id', $id)->first(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage(),
            ]);
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
            Auditoria::create([
                'created_by' => auth()->user()->id,
                'entidad_type' => Producto::class,
                'entidad_id' => $producto->id,
                'accion' => 'Actualización de producto'
            ]);
            AuditoriaCreadaEvent::dispatch(tenant_id());
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

    public function delete(string $id)
    {
        try {
            $query = Producto::query();
            $productos = $query->get();
            $producto = Producto::find($id);
            $producto->delete();
            $producto->save();
            Auditoria::create([
                'created_by' => auth()->user()->id,
                'entidad_type' => Producto::class,
                'entidad_id' => $producto->id,
                'accion' => 'Eliminacion de producto'
            ]);
            AuditoriaCreadaEvent::dispatch(tenant_id());
            return response()->json([
                'success' => true,
                'message' => "producto borrado",
                'total' => count($productos),
                'totalServicios' => count($productos->where('tipo', 'servicio')),
                'totalProductos' => count($productos->where('tipo', 'producto')),
                'stock' => count(Producto::where('tipo', 'producto')->whereColumn('stock_minimo', '>=', 'stock')->where('stock', '!=', 0)->get()),
                'sinStock' => count(Producto::where('stock', 0)->get()),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage(),
            ]);
        }
    }

    public function import_excel(Request $request)
    {
        try {
            $request->validate([
                'productos' => 'required|mimes:xlsx,xls,csv'
            ]);
            $file = $request->file('productos');
            Excel::import(new ProductosImport, $file);

            Auditoria::create([
                'created_by' => auth()->user()->id,
                'entidad_type' => Producto::class,
                'entidad_id' => 1,
                'accion' => 'Importación de productos por excel'
            ]);
            AuditoriaCreadaEvent::dispatch(tenant_id());
            return response()->json([
                'success' => true,
                'message' => 'Productos importados'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function top_ventas()
    {
        $productos = Producto::orderByDesc('ventas')->get();
        return view('reportes.includes.all-productos', [
            'productos' => $productos,
        ]);
    }
}
