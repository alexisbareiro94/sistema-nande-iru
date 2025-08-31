<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoCaja extends Model
{
    protected $table = 'movimiento_cajas';

    protected $fillable = [
        'caja_id',
        'tipo',
        'concepto',
        'monto',
    ];

    public function caja(){
        return $this->belongsTo(Caja::class, 'caja_id');
    }
}
