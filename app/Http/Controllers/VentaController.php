<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVentaRequest;
use App\Services\VentaService;
use App\Models\{MovimientoCaja, User, Venta, DetalleVenta, Caja, Pago, Producto};
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function __construct(protected VentaService $ventaService) {}

    public function index_view()
    {
        $query = Venta::query();
        $clientes = User::where('role', 'cliente')->selectRaw('count(*) as total_users')->first()->total_users;
        $totalVentas = count($query->get());
        $ingresos = $query->sum('total');
        $ingresosHoy = $query->where('created_at', '>=', now()->format('Y-m-d'))->get()->sum('total');
        $ventas = Venta::orderByDesc('id')->with('cliente')->paginate(10);

        return view('caja.historial-completo.index', [
            'clientes' => $clientes,
            'totalVentas' => $totalVentas,
            'ingresos' => $ingresos,
            'ingresosHoy' => $ingresosHoy,
            'ventas' => $ventas,
        ]);
    }

    public function show(string $codigo)
    {
        try {
            $venta = Venta::where('codigo', $codigo)->with(['detalleVentas', 'cliente', 'pagos'])->first();
            $productos = Producto::whereHas('detalles', function ($query) use ($venta) {
                            return $query->where('venta_id', $venta->id);
                        })->with(['detalles' => function ($query) use ($venta) {
                            $query->where('venta_id', $venta->id);
                        }])->get();

            return response()->json([
                'success' => true,
                'productos' => $productos,
                'venta' => $venta,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function store(StoreVentaRequest $request)
    {
        $data = $request->validated();  //aca se valida que llegue el carrito y demas datos        
        $errores = $this->ventaService->validate_data($data); //aca valido los datos del carrito y el usuario

        if ($errores->count() > 0) {
            return response()->json([
                'success' => false,
                'errores' => $errores->first(),
                'es en el service'
            ], 400);
        }

        $carrito = collect(json_decode($data['carrito']));
        $totalCarrito = collect(json_decode($data['total']));
        $formaPago = collect(json_decode($data['forma_pago']));
        $ruc = $data['ruc'];
        $userId = User::where('ruc_ci', $ruc)->pluck('id')->first();
        $cajaId = Caja::where('estado', 'abierto')->pluck('id')->first();

        $tieneDescuento = $carrito->contains(function ($item) {
            return $item->descuento === true;
        });

        DB::beginTransaction();
        try {
            $venta = Venta::create([
                'caja_id' => $cajaId,
                'codigo' => generate_code(),
                'cliente_id' => $userId,
                'cantidad_productos' => $totalCarrito['cantidadTotal'],
                'con_descuento' => $tieneDescuento,
                'monto_descuento' => $totalCarrito['subtotal'] - $totalCarrito['total'],
                'subtotal' => $totalCarrito['subtotal'],
                'total' => $totalCarrito['total'],
                'estado' => 'completado',
            ]);

            MovimientoCaja::create([
                'caja_id' => $cajaId,
                'tipo' => 'ingreso',
                'concepto' => 'Venta de productos',
                'monto' => $venta->total,
            ]);

            $productos = [];
            foreach ($carrito as $id => $producto) {
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $id,
                    'cantidad' => $producto->cantidad,
                    'precio_unitario' => $producto->precio,
                    'producto_con_descuento' => $producto->descuento,
                    'precio_descuento' => $producto->precio_descuento,
                    'subtotal' => $producto->cantidad * $producto->precio,
                    'total' => $producto->descuento === true ? $producto->cantidad * $producto->precio_descuento : $producto->cantidad * $producto->precio,
                ]);

                $productdb = Producto::find($id);
                $productos[] = $productdb;
                if ($productdb->tipo === 'producto') {
                    if ($producto->cantidad < $productdb->stock) {
                        $productdb->decrement('stock', $producto->cantidad);
                    } else {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'error' => 'No hay stock suficiente: ' . $producto->nombre,
                            'stock' => $productdb->stock,
                            'carrito_cantidad' => $producto->cantidad,
                        ], 400);
                    }
                }
            }

            foreach ($formaPago as $forma => $monto) {
                if ($forma == 'mixto') {
                    foreach ($monto as $metodo => $pago) {
                        Pago::create([
                            'venta_id' => $venta->id,
                            'metodo' => $metodo,
                            'monto' => $pago,
                            'estado' => 'completado',
                        ]);
                    }
                } else {
                    Pago::create([
                        'venta_id' => $venta->id,
                        'metodo' => $forma,
                        'monto' => $monto,
                        'estado' => 'completado',
                    ]);
                }
            }

            $caja = session('caja');
            $caja['saldo'] += $venta->total;
            session()->put(['caja' => $caja]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Venta realizada con exito',
                'venta' => $venta->load('cliente:id,razon_social,ruc_ci'),
                'productos' => $productos,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
