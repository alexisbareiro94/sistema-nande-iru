<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbrirCajaRequest;
use App\Models\{Caja, MovimientoCaja};
use App\Services\CajaService;

class CajaController extends Controller
{
    public function __construct(protected CajaService $cajaService){
        if( Caja::where('estado', 'abierto')->exists() && empty(session('caja'))){
            session('caja', []);
            $item = Caja::where('estado', 'abierto')->with('user:id,name,role')->first()->toArray();            
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
            session('caja', []);
            $caja = Caja::create($data);            

            MovimientoCaja::create([
                'caja_id' => $caja->id,
                'tipo' => 'ingreso',
                'concepto' => 'Apertura de caja',
                'monto' => $caja['monto_inicial']
            ]);

            $arrayCaja = $caja->toArray();
            $arrayCaja['saldo'] = $arrayCaja['monto_inicial'];
            session()->put(['caja' => $arrayCaja]);            
            return back()->with('success', 'Caja Abierta Correctamente');        
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }    
}
