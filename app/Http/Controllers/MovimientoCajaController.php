<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovimientoRequest;
use App\Jobs\CierreCaja;
use Illuminate\Http\Request;
use App\Models\{MovimientoCaja, Caja, PagoSalario, User};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Jobs\MovimientoRealizado;

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
        DB::beginTransaction();
        try {
            $movimiento = MovimientoCaja::create($data);
            crear_caja();
            if($data['personal_id'] != null){
                $user = User::find($data['personal_id']);
                if($data['monto'] < $user->salario){
                    $adelanto = true;
                    $restante = $user->salario - $data['monto'];
                }else{
                    $adelanto = false;
                    $restante = 0;
                }
                PagoSalario::create([
                    'user_id' => $data['personal_id'],
                    'movimiento_id' => $movimiento->id,
                    'adelanto' => $adelanto,
                    'monto' => $data['monto'],
                    'restante' => $restante,
                    'created_by' => $request->user()->id,
                ]);                
            }
            DB::commit();            
            MovimientoRealizado::dispatch($movimiento, $movimiento->tipo);            
            return response()->json([
                'success' => true,
                'message' => 'Movimiento registrado correctamente',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
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

            $queryDesde = $request->query('desde') == null ? null : Carbon::parse($request->query('desde'))->startOfDay();
            $queryHasta = $request->query('hasta') == null ? null : Carbon::parse($request->query('hasta'))->endOfDay();
            
            $desde = $queryDesde ?: $periodoInicio;
            $hasta = $queryHasta ?: $periodoFin;            
            
            $movimientos = MovimientoCaja::selectRaw("
                    $formatoGroup as periodo,
                    SUM(CASE WHEN tipo = 'ingreso' THEN monto ELSE 0 END) as ingresos,
                    SUM(CASE WHEN tipo = 'egreso' THEN monto ELSE 0 END) as egresos
                ")
                ->whereBetween('created_at', [$desde, $hasta])
                ->groupBy('periodo')
                ->orderByRaw("MIN(created_at)")
                ->get();
            //dd($movimientos, $desde,$hasta);
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
