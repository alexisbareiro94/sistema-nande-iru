<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{MovimientoCaja, Venta, Producto, Pago, DetalleVenta};
use App\Services\ReporteService;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function __construct(protected ReporteService $reporteService) {}

    public function index()
    {
        $datos = $this->reporteService->data_index();                  
        return view('reportes.index', [
            'data' => $datos
        ]);
    }

    public function tipos_pagos(string $periodo)
    {
        $inicio = now()->startOfDay()->subDay($periodo);
        $hoy = now()->endOfDay();
        try {
            $pagos =  Venta::whereBetween('created_at', [$inicio, $hoy])
                ->get()
                ->groupBy('forma_pago')
                ->map(fn($pago) => $pago->count());


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
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function ventas_chart(string $periodo)
    {
        $inicio = now()->startOfDay()->subDay($periodo);
        $hoy = now()->endOfDay();

        try {
            $ventas = Venta::whereBetween('created_at', [$inicio, $hoy])
                ->orderBy('created_at')
                ->get()
                ->groupBy(function ($venta) {
                    return Carbon::parse($venta->created_at)->format('Y-m-d');
                })
                ->map(function ($venta) {
                    return [
                        'total' => $venta->sum('total')
                    ];
                });

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

    public function tipo_venta(string $periodo)
    {
        $inicio = now()->startOfDay()->subDay($periodo);
        $hoy = now()->endOfDay();

        try {
            $conteo = [
                'producto' => 0,
                'servicio' => 0,
            ];

            $ventas = Venta::whereBetween('created_at', [$inicio, $hoy])
                ->with('productos')
                ->get();

            foreach ($ventas as $venta) {
                foreach ($venta->productos as $producto) {
                    if ($producto->tipo === 'producto') {
                        $conteo['producto']++;
                    } elseif ($producto->tipo === 'servicio') {
                        $conteo['servicio']++;
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
     *  opcion = seria para comparar con la semana completa anterior o igualar al dia de hoy 
     */
    public function tendencia(string $periodo, ?string $opcion = null){          
        try{
            $data = $this->reporteService->utilidad($periodo, $opcion);            
            $data['actual']['fecha_apertura'] = Carbon::parse($data['actual']['fecha_apertura'])->format('d-m');
            $data['actual']['fecha_cierre'] = Carbon::parse($data['actual']['fecha_cierre'])->format('d-m');

            $data['pasado']['fecha_apertura'] = Carbon::parse($data['pasado']['fecha_apertura'])->format('d-m');
            $data['pasado']['fecha_cierre'] = Carbon::parse($data['pasado']['fecha_cierre'])->format('d-m');
            
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }    
}
