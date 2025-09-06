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
        try{
            $ingreso = MovimientoCaja::where('tipo', 'ingreso')->selectRaw('SUM(monto) as total')->pluck('total');
            $egreso = MovimientoCaja::where('tipo', 'egreso')->selectRaw('SUM(monto) as total')->pluck('total');
            $total = $ingreso[0] - $egreso[0];
            return response()->json([
                'success' => true,
                'total' => $total,
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
