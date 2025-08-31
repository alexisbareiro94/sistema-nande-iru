<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = 'cajas';

    protected $fillable = [
        'user_id',
        'monto_inicial',
        'monto_cierre',
        'estado',
        'diferencia',
        'fecha_apertura',
        'fecha_cierre',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function movimientos(){
        return $this->hasMany(MovimientoCaja::class);
    }
}
