<?php

namespace App\Http\Controllers;

use App\Events\AuditoriaCreadaEvent;
use App\Http\Requests\StoreMovimientoRequest;
use Illuminate\Http\Request;
use App\Models\{Auditoria, MovimientoCaja, Caja};
use App\Services\MovimientoService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Jobs\MovimientoRealizado;

class MovimientoCajaController extends Controller
{
    public function __construct(protected MovimientoService $movimientoService) {}

    public function index(Request $request)
    {
        if (auth()->user()->role == 'admin') {
            $movimientos = MovimientoCaja::orderBy('created_at', 'desc')->limit(3)->get();
        } else {
            $movimientos = MovimientoCaja::orderBy('created_at', 'desc')
                ->whereHas('venta', function ($query) {
                    return $query->where('vendedor_id', auth()->user()->id);
                })
                ->limit(3)
                ->get();
        }
        return response()->json([
            'movimientos' => $movimientos,
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
            Auditoria::create([
                'created_by' => auth()->user()->id,
                'entidad_type' => MovimientoCaja::class,
                'entidad_id' => $movimiento->id,
                'accion' => 'Registro de movimiento en caja',
                'datos' => [
                    'monto' => $data['monto'],
                    'tipo' => $data['tipo'] 
                ]
            ]);
            AuditoriaCreadaEvent::dispatch(tenant_id());
            crear_caja();
            if ($data['personal_id'] != null) {
                $pago = $this->movimientoService->pago_salario($data, $movimiento, $request->user()->id);

                if ($pago == false) {
                    DB::rollBack();
                    return response()->json([
                        'error' => 'Error al pagar el salario'
                    ], 400);
                }
            }            
            DB::commit();
            MovimientoRealizado::dispatch($movimiento, $movimiento->tipo, tenant_id());            
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
            if ($periodo == 'mes') {
                $periodoInicio = now()->startOfMonth();
                $periodoFin    = now()->endOfMonth();
                $formatoGroup  = "TO_CHAR(created_at, 'MM-YYYY')";
            } elseif ($periodo == 'anio' || $periodo == 'año') {
                $periodoInicio = now()->startOfYear();
                $periodoFin    = now()->endOfYear();
                $formatoGroup  = "TO_CHAR(created_at, 'YYYY')";
            } else {
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
