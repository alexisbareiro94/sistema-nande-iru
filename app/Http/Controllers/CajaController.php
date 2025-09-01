<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AbrirCajaRequest;
use App\Models\Caja;
use App\Services\CajaService;

class CajaController extends Controller
{
    public function __construct(protected CajaService $cajaService){
        if( Caja::where('estado', 'abierto')->exists() && empty(session('caja'))){
            session('caja', []);
            $item = Caja::where('estado', 'abierto')->first()->toArray();
            $item['saldo'] = $item['monto_inicial'];
            session()->put(['caja' => $item]);            
        }
        
    }

    public function index_view(){
        if(!session('caja')){
            $caja = Caja::orderByDesc('id')->first();            
        }
        return view('caja.index', [
            'caja' => $caja ?? '',
        ]);
    }

    public function abrir(AbrirCajaRequest $request){
        $res = $request->validated();
        $data = $this->cajaService->set_data($res);
                
        try{            
            $caja = Caja::create($data);            
            $ses = session('caja')->toArray();
            $ses['saldo'] = (int)session('caja')->monto_inicial;
            session(['caja' => $ses]);            
            return back()->with('success', 'Caja Abierta Correctamente');        
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
}
