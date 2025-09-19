<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{MovimientoCaja, Venta, Producto, Pago};
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
            $transferencia = $pagos['transferencia'];
            $efectivo = $pagos['efectivo'];

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
}
