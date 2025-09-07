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
        'tipo',
        'concepto',
        'monto',
    ];

    public function caja(){
        return $this->belongsTo(Caja::class);
    }
}
