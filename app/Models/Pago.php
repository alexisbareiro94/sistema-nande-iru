<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pago extends Model
{
    use HasFactory;
    
    protected $table = 'pagos';

    protected $fillable = [
        'venta_id',
        'metodo',    
        'monto',
        'estado',
        'caja_id',
    ];

    public function venta(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }    

    public function caja(){
        return $this->belongsTo(Caja::class);
    }
}
