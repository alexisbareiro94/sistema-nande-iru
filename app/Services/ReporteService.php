<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\{Producto, User, Venta, MovimientoCaja, DetalleVenta};
use Carbon\Carbon;

class ReporteService
{
    //datos para los tres primeros items de reportes (ventas hoy, clientes nuevos, prod mas vendido y mas vendidos )
    public function data_index(): array
    {
        $productos = Producto::orderByDesc('ventas')->get()->take(4);
        $productoMasVendido = $productos->first();
        $productos = $productos->where('id', '!=', $productoMasVendido->id);

        $inicioMesPasado = Carbon::now()->startOfMonth()->subMonth();
        $finMesPasado = Carbon::now()->endOfDay()->subMonth();
        $ventasMesPasado = Venta::whereBetween('created_at', [$inicioMesPasado, $finMesPasado])->get()->sum('total');

        $inicioMes = Carbon::now()->startOfMonth();
        $fechaActual = Carbon::now()->endOfMonth();
        $ventasEsteMes = Venta::whereBetween('created_at', [$inicioMes, $fechaActual])->get()->sum('total');

        $usersMesPasado = User::where('role', 'cliente')->whereBetween('created_at', [$inicioMesPasado, $finMesPasado])->get()->count();
        $usersEsteMes = User::where('role', 'cliente')->whereBetween('created_at', [$inicioMes, $fechaActual])->get()->count();

        $tagUsers = $usersEsteMes > $usersMesPasado ? '+' : '-';
        $porcentajeUsers = '';
        if ($usersEsteMes > $usersMesPasado) {
            $porcentajeUsers = (($usersEsteMes - $usersMesPasado) / $usersEsteMes) * 100;
        } else {
            $porcentajeUsers = (($usersMesPasado - $usersEsteMes) / $usersMesPasado) * 100;
        }

        $porcentaje = '';
        $tag = $ventasEsteMes > $ventasMesPasado ? '+' : '-';

        if ($ventasEsteMes > $ventasMesPasado) {
            $porcentaje = (($ventasEsteMes - $ventasMesPasado) / $ventasEsteMes) * 100;
        } else {
            $porcentaje = (($ventasMesPasado - $ventasEsteMes) / $ventasMesPasado) * 100;
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
            'productos_vendidos' =>  $productos,
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
                'fecha_apertura' => $aperturaActual,
                'fecha_cierre' => $cierreActual,
            ],
            'pasado' => [
                'total_venta' => 0,
                'ganancia' => 0,
                'descuento' => 0,
                'fecha_apertura' => $aperturaPasado,
                'fecha_cierre' => $cierrePasado,
            ],
            'periodo' => $periodo,
            'option' => $option,
            'tag' => '',
        ];
        $ventasActual = DetalleVenta::whereBetween('created_at', [$aperturaActual, $cierreActual])
            ->with('producto')
            ->get();

        $ventasPasada = DetalleVenta::whereBetween('created_at', [$aperturaPasado, $cierrePasado])
            ->with('producto')
            ->get();

        $datos['actual']['total_venta'] = $ventasActual->sum('total');
        $datos['pasado']['total_venta'] = $ventasPasada->sum('total');
        foreach ($ventasActual as $venta) {
            $datos['actual']['descuento'] += (($venta->producto->precio_compra ?? 0) * $venta->cantidad);
        }
        foreach ($ventasPasada as $venta) {
            $datos['pasado']['descuento'] += (($venta->producto->precio_compra ?? 0) * $venta->cantidad);
        }
        $datos['actual']['ganancia'] = $datos['actual']['total_venta'] - $datos['actual']['descuento'];
        $datos['pasado']['ganancia'] = $datos['pasado']['total_venta'] - $datos['pasado']['descuento'];

        $porcentaje = 0;
        if ($datos['actual']['ganancia'] > $datos['pasado']['ganancia']) {            
            $porcentaje = round((($datos['actual']['ganancia'] - $datos['pasado']['ganancia']) / $datos['actual']['ganancia']) * 100);
            $datos['tag'] = '+';
        } else {            
            $porcentaje = round((($datos['pasado']['ganancia'] - $datos['actual']['ganancia']) / $datos['pasado']['ganancia']) * 100);
            $datos['tag'] = '-';
        }
        $diferencia = $datos['actual']['ganancia'] - $datos['pasado']['ganancia'];
        $datos['diferencia'] = $diferencia ?? 0;
        $datos['porcentaje'] = $porcentaje ?? 0;

        return $datos;
    }

    public function gananacias_data() :array
    {
        $hoy = now()->endOfDay();
        $desde = now()->startOfDay()->subDay(7);

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
            ->map(fn($egreso)=> $egreso->sum('monto'));

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
            if (!empty($egresos[$fecha])) {
                $datos[$index]['egresos'] = ($egresos[$fecha]) ?? 0;
                $datos[$index]['ganacia_egresos'] = ($datos[$index]['ganancia'] - $datos[$index]['egresos']) ?? 0;
            }
            $index++;
        }
        $labels = $ventas->keys()->map(function ($fecha) {
            return date('d-m', strtotime($fecha));
        });

        return [
            'labels' => $labels,
            'datos' => $datos,
        ];
    }
}
