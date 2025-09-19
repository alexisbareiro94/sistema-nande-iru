<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbrirCajaRequest;
use App\Http\Requests\UpdateCajaRequest;
use App\Models\{Caja, MovimientoCaja, Venta, DetalleVenta, Producto, Pago};
use App\Services\CajaService;

class CajaController extends Controller
{
    public function __construct(protected CajaService $cajaService)
    {
        crear_caja();
    }
    public function index_view()
    {
        if (!session("caja")) {
            $caja = Caja::orderByDesc("id")->first();
        }
        return view("caja.index", [
            "caja" => $caja ?? "",
        ]);
    }

    public function abrir(AbrirCajaRequest $request)
    {
        if (session("caja")) {
            return back()->with("error", "Ya existe una caja abierta");
        }
        $res = $request->validated();
        $data = $this->cajaService->set_data($res);

        try {
            session("caja", []);
            $caja = Caja::create($data);

            MovimientoCaja::create([
                "caja_id" => $caja->id,
                "tipo" => "ingreso",
                "concepto" => "Apertura de caja",
                "monto" => $caja["monto_inicial"],
            ]);

            $arrayCaja = $caja->load("user:id,name")->toArray();
            $arrayCaja["saldo"] = $arrayCaja["monto_inicial"];
            session()->put(["caja" => $arrayCaja]);
            return back()->with("success", "Caja Abierta Correctamente");
        } catch (\Exception $e) {
            return back()->with("error", $e->getMessage());
        }
    }

    public function update(UpdateCajaRequest $request)
    {
        //cuando se cierra la caja
        $data = $request->validated();
        //return response()->json([$data, now()]);
        $ingreso = 0;
        $egreso = 0;
        try {
            $caja = Caja::where("estado", "abierto")->first();
            if ($caja == null) {
                return response()->json(
                    [
                        "success" => false,
                        "error" => "La caja ya esta cerrada",
                    ],
                    400,
                );
            }
            $caja->update([
                "monto_cierre" => $data["monto_cierre"], // monto contado
                "saldo_esperado" => $data["saldo_esperado"],
                "diferencia" => $data["diferencia"],
                "observaciones" => $data["observaciones"],
                "egresos" => $data["egreso"],
                "fecha_cierre" => now(),
                "estado" => "cerrado",
                "updated_by" => auth()->user()->id,
            ]);

            session()->forget("caja");

            return response()->json([
                "success" => true,
                "message" => "Caja cerrada correctamente",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "error" => $e->getMessage(),
            ]);
        }
    }
    public function show(string $id)
    {
        try {
            $caja = Caja::find($id);
            $transacciones = Venta::where("caja_id", $caja->id)->count();
            $mayorVenta = Venta::where("caja_id", $caja->id)
                ->orderByDesc("total")
                ->first()->total;
            $promedioVenta = $caja->monto_cierre / $transacciones;
            $clientes = Venta::where("caja_id", $caja->id)
                ->get()
                ->unique("cliente_id")
                ->count();
            $efectivo = Pago::where("caja_id", $caja->id)
                ->where("metodo", "efectivo")
                ->sum("monto");
            $transferencia = Pago::where("caja_id", $caja->id)
                ->where("metodo", "transferencia")
                ->sum("monto");

            $ventas = DetalleVenta::where("caja_id", $caja->id)
                ->with("producto:id,nombre")
                ->get()
                ->groupBy("producto_id")
                ->map(function ($items) {
                    return [
                        "cantidad" => $items->sum("cantidad"),
                        "producto" => $items->first()->producto->nombre,
                        "total" => $items->sum("total"),
                    ];
                })
                ->sortByDesc("total")
                ->take(3); //by: chatGPT, yo lo había hecho con dos foreachs (uno dentro de otro) y arrays, llegue al mismo resultado, pero este es mas bonito :D

            $total = $efectivo + $transferencia;
            $efecPorcentaje = (100 * $efectivo) / $total;
            $transfProcentaje = (100 * $transferencia) / $total;

            $datos = [
                "caja" => $caja->load("user"),
                "ventas" => $ventas->values()->toArray(),
                "transacciones" => $transacciones,
                "clientes" => $clientes,
                "efectivo" => $efectivo,
                "efecPorcentaje" => round($efecPorcentaje, 0),
                "transferencia" => $transferencia,
                "transfProcentaje" => round($transfProcentaje, 0),
                "mayorVenta" => $mayorVenta,
                "promedio" => round($promedioVenta, 0),
            ];

            return response()->json([
                "success" => true,
                "datos" => $datos,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "error" => $e->getMessage(),
            ]);
        }
    }

    public function anteriores()
    {
        return view("caja.anteriores.index", [
            "cajas" => Caja::all(),
        ]);
    }
}
