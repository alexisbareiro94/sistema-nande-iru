<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class CajaService
{
    public function set_data($res) :array {
        
        return $data = [
            'user_id' => Auth::id(),
            'monto_inicial' => $res['monto_inicial'],
            'monto_cierre' => null,
            'estado' => 'abierto',
            'diferencia' => null,
            'fecha_apertura' => now(),
            'fecha_cierre' => null,
        ];        
    }
}
