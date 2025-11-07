<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{MovimientoCaja, Venta};
use App\Services\ReporteService;
use Carbon\Carbon;
use App\Events\NotificacionEvent;

class ReporteController extends Controller
{
    public function __construct(protected ReporteService $reporteService) {}

    public function index()
    {
        $datos = $this->reporteService->data_index();
        return view('reportes.index', [
            'data' => $datos ?? ''
        ]);
    }

    public function tipos_pagos(string $periodo)
    {
        try {
            $inicio = now()->startOfDay()->subDay($periodo);
            $hoy = now()->endOfDay();
            $pagos =  Venta::whereBetween('created_at', [$inicio, $hoy])
                ->get()
                ->groupBy('forma_pago')
                ->map(fn($pago) => $pago->count());
            $ingresos = Venta::whereBetween('created_at', [$inicio, $hoy])
                ->with('productos')
                ->get()
                ->groupBy('forma_pago')
                ->map(fn($venta) => $venta->sum('total'))
                ->toArray();

            $labels = $pagos->keys();
            $mixto = $pagos['mixto'] ?? 0;
            $transferencia = $pagos['transferencia'] ?? 0;
            $efectivo = $pagos['efectivo'] ?? 0;

            return response()->json([
                'success' => true,
                'labels' => $labels,
                'mixto' => $mixto,
                'transferencia' => $transferencia,
                'efectivo' => $efectivo,
                'ingresos' => $ingresos,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @param
     * periodo: 7, 30, 90, representa el rango de fechas
     */
    public function ventas_chart(string $periodo)
    {
        try {
            $inicio = now()->startOfDay()->subDay($periodo);
            $hoy = now()->endOfDay();

            $ventas = Venta::whereBetween('created_at', [$inicio, $hoy])
                ->orderBy('created_at')
                ->get()
                ->groupBy(function ($venta) {
                    return Carbon::parse($venta->created_at)->format('Y-m-d');
                })
                ->map(fn($venta) => ['total' => $venta->sum('total')]);

            $labels = $ventas->keys();

            return response()->json([
                'success' => true,
                'labels' => $labels,
                'ventas' => $ventas,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @param
     * periodo= 7, 30 o 90, representa el rango que se va a medir
     */
    public function tipo_venta(string $periodo)
    {
        try {
            $inicio = now()->startOfDay()->subDay($periodo);
            $hoy = now()->endOfDay();
            $conteo = [
                'producto' => 0,
                'servicio' => 0,
                'ingresos' => [
                    'producto' => 0,
                    'servicio' => 0,
                ],
            ];

            $ventas = Venta::whereBetween('created_at', [$inicio, $hoy])
                ->with('productos')
                ->get();
            foreach ($ventas as $venta) {
                foreach ($venta->productos as $producto) {
                    if ($producto->tipo === 'producto') {
                        $conteo['producto']++;
                        $conteo['ingresos']['producto'] += $venta->total;
                    } elseif ($producto->tipo === 'servicio') {
                        $conteo['servicio']++;
                        $conteo['ingresos']['servicio'] += $venta->total;
                    }
                }
            }
            $labels = array_keys($conteo);

            return response()->json([
                'labels' => $labels,
                'conteo' => $conteo,
            ]);

            return response();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
    /**
     * @params
     * function= para la comparativa por dia, semana o mes
     * opción = seria para comparar con la semana o mes completa anterior (== null) o igualar al dia de hoy (== hoy)
     * egreso= le resta los egresos
     */
    public function tendencia(string $periodo, ?string $opcion = null)
    {
        try {
            $data = $this->reporteService->utilidad($periodo, $opcion);
            $data['actual']['fecha_apertura'] = Carbon::parse($data['actual']['fecha_apertura'])->format('d-m');
            $data['actual']['fecha_cierre'] = Carbon::parse($data['actual']['fecha_cierre'])->format('d-m');

            $data['pasado']['fecha_apertura'] = Carbon::parse($data['pasado']['fecha_apertura'])->format('d-m');
            $data['pasado']['fecha_cierre'] = Carbon::parse($data['pasado']['fecha_cierre'])->format('d-m');

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function gananacias(string $periodo)
    {
        try {
            $data = $this->reporteService->gananacias_data($periodo);

            return response()->json([
                'labels' => $data['labels'],
                'datos' => $data['datos'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function egresos(string $periodo)
    {
        try {
            $inicio = now()->startOfDay()->subDay($periodo);
            $hoy = now()->endOfDay();

            $movs = MovimientoCaja::where('tipo', 'egreso')
                ->whereBetween('created_at', [$inicio, $hoy])
                ->orderBy('created_at')
                ->get()
                ->groupBy(function ($query) {
                    return Carbon::parse($query->created_at)->format('d-m-Y');
                })
                ->map(fn($mov) => ['total' => $mov->sum('monto')]);

            return response()->json([
                'success' => true,
                'labels' => $movs->keys(),
                'egresos' => $movs,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function egresos_concepto(string $periodo)
    {
        try {
            $inicio = now()->startOfDay()->subDay($periodo);
            $hoy = now()->endOfDay();

            $movs = MovimientoCaja::where('tipo', 'egreso')
                ->whereBetween('created_at', [$inicio, $hoy])
                ->orderBy('created_at')
                ->get()
                ->groupBy('concepto')
                ->map(fn($mov) => ['total' => $mov->sum('monto')]);

            return response()->json([
                'success' => true,
                'egresos' => $movs,
                'labels' => $movs->keys(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
