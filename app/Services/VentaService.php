<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Models\Producto;

class VentaService
{
    public function validate_data($data) 
    {        
        $carrito = collect(json_decode($data['carrito']));
        $ruc = $data['ruc'];
        $errores = [];
        session(['ruc' => $ruc]);
        foreach ($carrito as $id => $producto) {
            if (!Producto::find($id)) {
                $errores['productos'] = ["producto con id: $id, no existe"];
            }
        }
        if (!User::where('ruc_ci', $ruc)->first()) {
            $errores['user'] = ['El usuario no existe'];
        }        
        return collect($errores);
    }
}
