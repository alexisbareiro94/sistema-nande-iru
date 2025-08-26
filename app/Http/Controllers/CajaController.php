<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CajaController extends Controller
{
    public function index_view(){
        return view('caja.index');
    }
}
