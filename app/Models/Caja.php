<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Caja extends Model
{
    use HasFactory;
    protected $table = 'cajas';

    protected $fillable = [
        'user_id',
        'monto_inicial',
        'monto_cierre',
        'fecha_apertura',
        'fecha_cierre',
        'saldo_esperado',
        'diferencia',
        'observaciones',
        'estado',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movimientos()
    {
        return $this->hasMany(MovimientoCaja::class, 'caja_id');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
