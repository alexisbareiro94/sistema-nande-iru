<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovimientoRequest;
use Illuminate\Http\Request;
use App\Models\{MovimientoCaja, Caja};

class MovimientoCajaController extends Controller
{
    public function index(){
        return response()->json([
            'movimientos' => MovimientoCaja::orderBy('id', 'desc')->limit(3)->get(),
        ]);
    }    

    public function total(){
        $ingreso = 0;
        $egreso = 0;
        try{
            if(session('caja')){
                $ingreso = MovimientoCaja::where('tipo', 'ingreso')->whereHas('caja', function($query){
                    $query->where('estado', 'abierto');
                })->selectRaw('SUM(monto) as total')->first()->total;

                $egreso = MovimientoCaja::where('tipo', 'egreso')->whereHas('caja', function($query){
                    $query->where('estado', 'abierto');
                })->selectRaw('SUM(monto) as total')->first()->total;
                if($egreso === null){
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
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function store(StoreMovimientoRequest $request){
        $data = $request->validated();
        $data['caja_id'] = Caja::where('estado', 'abierto')->pluck('id')->first();        
        try{
            MovimientoCaja::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Movimiento registrado correctamente',
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
