<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MovimientoCaja extends Model
{
    use HasFactory;
    protected $table = 'movimiento_cajas';

    protected $fillable = [
        'caja_id',
        'venta_id',
        'tipo',
        'concepto',
        'monto',
    ];

    public function caja(){
        return $this->belongsTo(Caja::class);
    }

    public function venta(){
        return $this->belongsTo(Venta::class);
    }

    public function pagos_salarios(){
        return $this->hasOne(PagoSalario::class, 'movimiento_id');
    }
}
