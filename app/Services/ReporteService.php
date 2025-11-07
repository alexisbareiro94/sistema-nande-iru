<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\DetalleVenta;
use App\Models\MovimientoCaja;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use Carbon\Carbon;

class ReporteService
{
    // datos para los tres primeros items de reportes (ventas hoy, clientes nuevos, prod mas vendido y mas vendidos )
    public function data_index(): array
    {
        if(Producto::all()->count() < 1){
            return [];
        }
        $productos = Producto::orderByDesc('ventas')->get()->take(4);
        $productoMasVendido = $productos->first();
        $productos = $productos->where('id', '!=', $productoMasVendido->id);

        $inicioMesPasado = Carbon::now()->startOfMonth()->subMonth();
        $finMesPasado = Carbon::now()->endOfDay()->subMonth();
        $ventasMesPasado = max(1, Venta::whereBetween('created_at', [$inicioMesPasado, $finMesPasado])->get()->sum('total'));

        $inicioMes = Carbon::now()->startOfMonth();
        $fechaActual = Carbon::now()->endOfMonth();
        $ventasEsteMes = max(1, Venta::whereBetween('created_at', [$inicioMes, $fechaActual])->get()->sum('total'));

        $usersMesPasado = max(1, User::where('role', 'cliente')->whereBetween('created_at', [$inicioMesPasado, $finMesPasado])->get()->count());
        $usersEsteMes = max(1, User::where('role', 'cliente')->whereBetween('created_at', [$inicioMes, $fechaActual])->get()->count());

        $tagUsers = '';
        $porcentajeUsers = '';
        if ($usersMesPasado != 0) {
            $valor = (($usersEsteMes - $usersMesPasado) / $usersMesPasado) * 100;
            $porcentajeUsers = round(abs($valor));
            $tagUsers = $valor >= 0 ? '+' : '-';
        } else {
            $porcentajeUsers = 0;
            $tagUsers = $usersEsteMes > 0 ? '+' : ($usersEsteMes < 0 ? '-' : '');
        }

        $porcentaje = '';
        $tag = '';
        if ($ventasMesPasado != 0) {
            $valor = (($ventasEsteMes - $ventasMesPasado) / $ventasMesPasado) * 100;
            $porcentaje = round(abs($valor));
            $tag = $valor >= 0 ? '+' : '-';
        } else {
            $porcentaje = 0;
        }

        return [
            'ventas_hoy' => [
                'saldo' => $ventasEsteMes,
                'porcentaje' => round($porcentaje),
                'tag' => $tag,
            ],
            'clientes_nuevos' => [
                'nuevos' => $usersEsteMes,
                'porcentaje' => round($porcentajeUsers),
                'tag' => $tagUsers,
            ],
            'producto_vendido' => [
                'producto' => $productoMasVendido,
                'cantidad' => $productoMasVendido->ventas,
            ],
            'productos_vendidos' => $productos,
            'utilidad' => $this->utilidad(),
        ];
    }

    public function utilidad($periodo = 'dia', $option = null)
    {
        $aperturaActual = $periodo == 'dia' ? now()->startOfDay() : ($periodo == 'semana' ? now()->startOfWeek() : now()->startOfMonth());
        $cierreActual = match ($periodo) {
            'dia' => now()->endOfDay(),
            'semana' => $option === 'hoy' ? now() : now()->endOfWeek(),
            'mes' => $option === 'hoy' ? now() : now()->endOfMonth(),
            default => now(),
        };

        $aperturaPasado = $periodo == 'dia' ? now()->startOfDay()->subDay() : ($periodo == 'semana' ? now()->startOfWeek()->subWeek() : now()->startOfMonth()->subMonth());
        $cierrePasado = match ($periodo) {
            'dia' => now()->endOfDay()->subDay(),
            'semana' => $option === 'hoy' ? now()->endOfDay()->subWeek() : now()->endOfWeek()->subWeek(),
            'mes' => $option === 'hoy' ? now()->endOfDay()->subMonth() : now()->endOfMonth()->subMonth(),
            default => now(),
        };
        $datos = [
            'actual' => [
                'total_venta' => 0,
                'ganancia' => 0,
                'descuento' => 0,
                'egreso' => 0,
                'ganancia_egreso' => 0,
                'fecha_apertura' => $aperturaActual,
                'fecha_cierre' => $cierreActual,
            ],
            'pasado' => [
                'total_venta' => 0,
                'ganancia' => 0,
                'descuento' => 0,
                'egreso' => 0,
                'ganancia_egreso' => 0,
                'fecha_apertura' => $aperturaPasado,
                'fecha_cierre' => $cierrePasado,
            ],
            'periodo' => $periodo,
            'option' => $option,
            'tag' => '',
        ];

        //ingresos de ventas
        $ventasActual = DetalleVenta::whereBetween('created_at', [$aperturaActual, $cierreActual])
            ->with('producto')
            ->get();
        $ventasPasada = DetalleVenta::whereBetween('created_at', [$aperturaPasado, $cierrePasado])
            ->with('producto')
            ->get();

        //otros ingresos
        $otrosIngresosActual = MovimientoCaja::where('concepto', '!=', 'Apertura de caja')
            ->where('concepto', '!=', 'Venta de productos')
            ->where('tipo', '!=', 'egreso')
            ->whereBetween('created_at', [$aperturaActual, $cierreActual])
            ->get()
            ->sum('monto');            
        $datos['actual']['ganancia'] = $otrosIngresosActual;

        $otrosIngresosPasado = MovimientoCaja::where('concepto', '!=', 'Apertura de caja')
            ->where('concepto', '!=', 'Venta de productos')
            ->where('tipo', '!=', 'egreso')
            ->whereBetween('created_at', [$aperturaPasado, $cierrePasado])
            ->get()
            ->sum('monto');
        $datos['pasado']['ganancia'] = $otrosIngresosPasado;

        //egresos
        $egresosActual = MovimientoCaja::where('tipo', 'egreso')
            ->whereBetween('created_at', [$aperturaActual, $cierreActual])
            ->get()
            ->sum('monto');

        $egresosPasada = MovimientoCaja::where('tipo', 'egreso')
            ->whereBetween('created_at', [$aperturaPasado, $cierrePasado])
            ->get()
            ->sum('monto');

        $datos['actual']['total_venta'] = $ventasActual->sum('total');
        $datos['pasado']['total_venta'] = $ventasPasada->sum('total');
        foreach ($ventasActual as $venta) {
            $datos['actual']['descuento'] += (($venta->producto->precio_compra ?? 0) * $venta->cantidad);
        }
        foreach ($ventasPasada as $venta) {
            $datos['pasado']['descuento'] += (($venta->producto->precio_compra ?? 0) * $venta->cantidad);
        }
        
        $datos['actual']['ganancia'] =  ($datos['actual']['total_venta'] + $datos['actual']['ganancia']) - $datos['actual']['descuento'];
        $datos['pasado']['ganancia'] =  ($datos['pasado']['total_venta'] + $datos['pasado']['ganancia']) - $datos['pasado']['descuento'];

        $actual = $datos['actual']['ganancia'];
        $pasado = $datos['pasado']['ganancia'];

        if ($pasado != 0) {
            $valor = (($actual - $pasado) / abs($pasado)) * 100;
            $porcentaje = round(abs($valor));
            $datos['tag'] = $valor >= 0 ? '+' : '-';
        } else {
            $porcentaje = 0;
            $datos['tag'] = $actual > 0 ? '+' : ($actual < 0 ? '-' : '');
        }

        $diferencia = $actual - $pasado;
        $datos['diferencia'] = $diferencia;
        $datos['porcentaje'] = $porcentaje;

        $datos['actual']['egreso'] = $egresosActual;
        $datos['actual']['ganancia_egreso'] = $datos['actual']['ganancia'] - $datos['actual']['egreso'];

        $datos['pasado']['egreso'] = $egresosPasada;
        $datos['pasado']['ganancia_egreso'] = $datos['pasado']['ganancia'] - $datos['pasado']['egreso'];

        $diferencia_egreso = $datos['actual']['ganancia_egreso'] - $datos['pasado']['ganancia_egreso'];
        $datos['diferencia_egreso'] = $diferencia_egreso;


        $actualEgreso = $datos['actual']['ganancia_egreso'];
        $pasadoEgreso = $datos['pasado']['ganancia_egreso'];

        if ($pasadoEgreso != 0) {
            $raw = (($actualEgreso - $pasadoEgreso) / abs($pasadoEgreso)) * 100;
            $porcentaje_egreso = round(abs($raw));
            $datos['tagE'] = $raw >= 0 ? '+' : '-';
        } else {
            $porcentaje_egreso = 0;
            $datos['tagE'] = $actualEgreso > 0 ? '+' : ($actualEgreso < 0 ? '-' : '');
        }
        $datos['porcentaje_egreso'] = $porcentaje_egreso;

        return $datos;
    }

    public function gananacias_data($periodo): array
    {
        $hoy = now()->endOfDay();
        $desde = now()->startOfDay()->subDay($periodo);

        $datos = [];

        $ventas = DetalleVenta::whereBetween('created_at', [$desde, $hoy])
            ->with('producto')
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($query) {
                return Carbon::parse($query->created_at)->format('Y-m-d');
            });
        
        $egresos = MovimientoCaja::whereBetween('created_at', [$desde, $hoy])
            ->where('tipo', 'egreso')
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($query) {
                return Carbon::parse($query->created_at)->format('Y-m-d');
            })
            ->map(fn($egreso) => $egreso->sum('monto'));     
            
        
        $otrosIngresos = MovimientoCaja::where('concepto', '!=', 'Apertura de caja')
            ->where('concepto', '!=', 'Venta de productos')
            ->where('tipo', '!=', 'egreso')
            ->whereBetween('created_at', [$desde, $hoy])
            ->get()
            ->groupBy(function ($query) {
                return Carbon::parse($query->created_at)->format('Y-m-d');
            })
            ->map(fn($ingreso) => $ingreso->sum('monto'));

        $index = 0;
        foreach ($ventas as $fecha => $detalles) {
            $total = $detalles->sum('total');
            $datos[$index] = [
                'fecha' => $fecha,
                'ganancia' => 0,
                'total_fecha' => $total,
                'descuento' => 0,
                'egresos' => 0,
                'ganacia_egresos' => 0,
            ];
            foreach ($detalles as $detalle) {
                $datos[$index]['descuento'] += ($detalle->producto->precio_compra * $detalle->cantidad) ?? 0;
            }
            $datos[$index]['ganancia'] = ($datos[$index]['total_fecha'] - $datos[$index]['descuento']) ?? 0;
            if (! empty($egresos[$fecha])) {
                $datos[$index]['egresos'] = ($egresos[$fecha]) ?? 0;
                $datos[$index]['ganacia_egresos'] = ($datos[$index]['ganancia'] - $datos[$index]['egresos']) ?? 0;
            }
            $index++;
        }        
        $labels = $ventas->keys()->map(function ($fecha) {
            return date('d-m', strtotime($fecha));
        });

        foreach($otrosIngresos as $index => $monto){
            foreach($datos as $i => $dato){            
                if($dato['fecha'] == $index){
                    $datos[$i]['ganancia'] += $monto;
                    $datos[$i]['ganacia_egresos'] += $monto;
                }
            }
        }

        return [
            'labels' => $labels,
            'datos' => $datos,
        ];
    }
}
