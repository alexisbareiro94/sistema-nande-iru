<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovimientoCaja;

class MovimientoCajaController extends Controller
{
    public function index(){
        return response()->json([
            'movimientos' => MovimientoCaja::orderBy('id', 'desc')->limit(3)->get(),
        ]);
    }    

    public function total(){
        try{
            $total = MovimientoCaja::selectRaw('SUM(monto) as total')->pluck('total');
            
            return response()->json([
                'success' => true,
                'total' => $total,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
