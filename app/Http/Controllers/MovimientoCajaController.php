<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovimientoRequest;
use Illuminate\Http\Request;
use App\Models\{MovimientoCaja, Caja};
use Carbon\Carbon;

class MovimientoCajaController extends Controller
{
    public function index()
    {
        return response()->json([
            'movimientos' => MovimientoCaja::orderBy('created_at', 'desc')->limit(3)->get(),
        ]);
    }

    public function total()
    {
        $ingreso = 0;
        $egreso = 0;
        try {
            if (session('caja')) {
                $ingreso = MovimientoCaja::where('tipo', 'ingreso')->whereHas('caja', function ($query) {
                    $query->where('estado', 'abierto');
                })->selectRaw('SUM(monto) as total')->first()->total;

                $egreso = MovimientoCaja::where('tipo', 'egreso')->whereHas('caja', function ($query) {
                    $query->where('estado', 'abierto');
                })->selectRaw('SUM(monto) as total')->first()->total;
                if ($egreso === null) {
                    $egreso = 0;
                }
            }
            $total = $ingreso - $egreso;
            return response()->json([
                'success' => true,
                'total' => $total,
                'egreso' => $egreso,
                'ingreso' => $ingreso,
                'caja' => session('caja'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function store(StoreMovimientoRequest $request)
    {
        $data = $request->validated();
        $data['caja_id'] = Caja::where('estado', 'abierto')->pluck('id')->first();
        try {
            MovimientoCaja::create($data);
            crear_caja();
            return response()->json([
                'success' => true,
                'message' => 'Movimiento registrado correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function charts_caja(Request $request)
    {
        try {
            $periodo = $request->query('periodoInicio') ?? 'semana';                        
            if($periodo == 'mes'){
                $periodoInicio = now()->startOfMonth();
                $periodoFin    = now()->endOfMonth();
                $formatoGroup  = "TO_CHAR(created_at, 'MM-YYYY')";
            }elseif($periodo == 'anio' || $periodo == 'año'){
                $periodoInicio = now()->startOfYear();
                $periodoFin    = now()->endOfYear();
                $formatoGroup  = "TO_CHAR(created_at, 'YYYY')";
            }else{
                $periodoInicio = now()->startOfWeek();
                $periodoFin    = now()->endOfWeek();
                $formatoGroup  = "TO_CHAR(created_at, 'DD-MM-YY')";
            }

            $desde = Carbon::parse($request->query('desde'))->startOfDay() ?: $periodoInicio;
            $hasta = Carbon::parse($request->query('hasta'))->endOfDay() ?: $periodoFin;
            
            $movimientos = MovimientoCaja::selectRaw("
                    $formatoGroup as periodo,
                    SUM(CASE WHEN tipo = 'ingreso' THEN monto ELSE 0 END) as ingresos,
                    SUM(CASE WHEN tipo = 'egreso' THEN monto ELSE 0 END) as egresos
                ")
                ->whereBetween('created_at', [$desde, $hasta])
                ->groupBy('periodo')
                ->orderByRaw("MIN(created_at)")
                ->get();
            
            return response()->json([
                'labels'   => $movimientos->pluck('periodo'),
                'ingresos' => $movimientos->pluck('ingresos'),
                'egresos'  => $movimientos->pluck('egresos'),
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
