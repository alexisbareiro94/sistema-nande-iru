<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';

    protected $fillable = [
        'venta_id',
        'metodo',    
        'monto',
        'estado',
    ];

    public function venta(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }

    public function metodo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MetodoPago::class);
    }
}
