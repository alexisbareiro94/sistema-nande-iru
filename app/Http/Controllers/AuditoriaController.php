<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auditoria;

class AuditoriaController extends Controller
{
    public function index(){
        return view('usuarios.all-auditorias', [
            'auditorias' => Auditoria::orderbyDesc('id')->paginate(15),
        ]);
    }
}
