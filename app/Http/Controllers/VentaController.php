<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function store(Request $request){
        return response()->json($request->all());
    }
}
