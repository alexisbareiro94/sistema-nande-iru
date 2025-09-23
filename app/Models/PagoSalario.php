<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoSalario extends Model
{
    protected $table = 'pago_salarios';

    protected $fillable = [
        'user_id',
        'movimiento_id',
        'adelanto',
        'monto',
        'restante',
        'created_by'
    ];
    
    public function movimientos(){
        return $this->belongsTo(MovimientoCaja::class);
    }
}
