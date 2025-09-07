<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbrirCajaRequest;
use App\Http\Requests\UpdateCajaRequest;
use App\Models\{Caja, MovimientoCaja};
use App\Services\CajaService;
use GuzzleHttp\Psr7\Request;

class CajaController extends Controller
{
    public function __construct(protected CajaService $cajaService)
    {
        if (Caja::where('estado', 'abierto')->exists() && empty(session('caja'))) {
            session('caja', []);
            $item = Caja::where('estado', 'abierto')->with('user:id,name,role')->first()->toArray();
            $item['saldo'] = $item['monto_inicial'];
            session()->put(['caja' => $item]);
        }
    }

    public function index_view()
    {
        if (!session('caja')) {
            $caja = Caja::orderByDesc('id')->first();
        }
        return view('caja.index', [
            'caja' => $caja ?? '',
        ]);
    }

    public function abrir(AbrirCajaRequest $request)
    {
        if (session('caja')) {
            return back()->with('error', 'Ya existe una caja abierta');
        }
        $res = $request->validated();
        $data = $this->cajaService->set_data($res);

        try {
            session('caja', []);
            $caja = Caja::create($data);

            MovimientoCaja::create([
                'caja_id' => $caja->id,
                'tipo' => 'ingreso',
                'concepto' => 'Apertura de caja',
                'monto' => $caja['monto_inicial']
            ]);

            $arrayCaja = $caja->load('user:id,name')->toArray();
            $arrayCaja['saldo'] = $arrayCaja['monto_inicial'];
            session()->put(['caja' => $arrayCaja]);
            return back()->with('success', 'Caja Abierta Correctamente');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(UpdateCajaRequest $request)
    {
        $data = $request->validated();
        //return response()->json([$data, now()]);
        $ingreso = 0;
        $egreso = 0;
        try {
            $caja = Caja::where('estado', 'abierto')->first();
            if ($caja == null) {
                return response()->json([
                    'success' => false,
                    'error' => 'La caja ya esta cerrada',
                ], 400);
            }
            $ingreso = MovimientoCaja::where('tipo', 'ingreso')->whereHas('caja', function ($query) {
                $query->where('estado', 'abierto');
            })->selectRaw('SUM(monto) as total')->first()->total;

            $egreso = MovimientoCaja::where('tipo', 'egreso')->whereHas('caja', function ($query) {
                $query->where('estado', 'abierto');
            })->selectRaw('SUM(monto) as total')->first()->total;
            if ($egreso === null) {
                $egreso = 0;
            }
            $total = $ingreso - $egreso;            
            $caja->update([
                'monto_cierre' => $data['monto_cierre'], // monto contado
                'saldo_esperado' => $total,
                'diferencia' => $data['diferencia'],
                'observaciones' => $data['observaciones'],
                'fecha_cierre' => now(),
                'estado' => 'cerrado',
                'updated_by' => auth()->user()->id,
            ]);

            session()->forget('caja');

            return response()->json([
                'success' => true,
                'message' => 'Caja cerrada correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
