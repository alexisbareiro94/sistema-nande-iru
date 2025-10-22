<?php

namespace App\Http\Controllers;

use App\Models\Distribuidor;
use Illuminate\Http\Request;
use App\Models\User;

class ClienteDistController extends Controller
{
    public function index(){
        $clientes = User::with('compras')
            ->where('role', 'cliente')
            ->where('activo', true)
            ->orderByDesc('created_at')            
            ->get()
            ->take(5);

        $distribuidores = Distribuidor::whereNot('id', 1)
            ->get()            
            ->take(5);
        return view('gestios-usuarios.index', [
            'clientes' => $clientes,
            'distribuidores' => $distribuidores,
        ]);
    }

    public function show_cliente(string $id){
        try{
            $cliente = User::findOrFail($id);
            return response()->json([
                'data' => $cliente
            ]);
        }catch(\Exception $e){
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function desactive(string $id){
        try{
            $user = User::findOrFail($id)
                ->update([
                    'activo' => false,
                ]);

                return response()->json([
                    'message' => 'Usuario eliminado'
                ]);
        }catch(\Exception $e){
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }
}
