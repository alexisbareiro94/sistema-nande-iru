<?php

declare(strict_types=1);

namespace App\Services;
use App\Models\{User, PagoSalario, MovimientoCaja};

class MovimientoService
{
    public function pago_salario(array $data, MovimientoCaja $movimiento, string $userId) :bool
    {
        $user = User::find($data['personal_id']);

        $adelanto = false;
        $restante = 0;
        if ($data['monto'] < $user->salario) {
            $ultimoPago = PagoSalario::where('user_id', $user->id)
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->orderByDesc('created_at')
                ->first()
                ?->restante;

            if (filled($ultimoPago) && $ultimoPago < $data['monto']) {                
                return false;
            }

            if ($ultimoPago && $ultimoPago > 0) {
                $restante = $ultimoPago - $data['monto'];
            } elseif ($user->salario == $data['monto']) {
                $restante = 0;
            } else {
                $adelanto = true;
                $restante = $user->salario - $data['monto'];
            }

            PagoSalario::create([
                'user_id' => $data['personal_id'],
                'movimiento_id' => $movimiento->id,
                'adelanto' => $adelanto,
                'monto' => $data['monto'],
                'restante' => $restante,
                'created_by' => $userId,
            ]);

            return true;
        } else {            
            return false;
        }
    }
}
