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
}
