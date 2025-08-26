<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venta extends Model
{
    use SoftDeletes;
    
    protected $table = 'ventas';

    protected $fillable = [
        'caja_id',
        'cliente_id',
        'venta_con_descuento',
        'monto_descuento',
        'subtotal',
        'total',
        'estado',
        'created_by',
        'updated_by',
        'deleted_by',
    ];


    public function cajero()
    {
        return $this->belongsTo(User::class, 'caja_id');
    }

    public function cliente(){
        return $this->belongsTo(User::class, 'cliente_id');
    }
}
