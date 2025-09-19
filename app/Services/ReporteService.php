<?php

declare(strict_types=1);

namespace App\Services;
use App\Models\{Producto, User, Venta, MovimientoCaja};
use Carbon\Carbon;

class ReporteService
{
    public function data_index() : array
    {
        $caja = session('caja', []);
        $saldo = 0;
        if ($caja) {
            $saldo = $caja['saldo'];
        }

        $productos = Producto::orderByDesc('ventas')->get()->take(4);
        $productoMasVendido = $productos->first();
        $productos = $productos->where('id', '!=', $productoMasVendido->id);
        $inicioMesPasado = Carbon::now()->subMonth()->startOfMonth();
        $finMesPasado = Carbon::now()->endOfDay()->subMonth();
        $ventasMesPasado = Venta::whereBetween('created_at', [$inicioMesPasado, $finMesPasado])->get()->sum('total');

        $inicioMes = Carbon::now()->startOfMonth();
        $fechaActual = Carbon::now()->endOfDay();
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
                'saldo' => $saldo,
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
            'productos_vendidos' =>  $productos
            
        ];
    }
}
