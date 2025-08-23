<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanCuota extends Model
{
    protected $table = 'planes_cuotas';

    protected $fillable = [
        'venta_id',
        'tipo_cuota_id',
        'cantidad_cuotas',
        'monto_total',
        'saldo',
        'fecha_inicio',
        'estado',
    ];

    public function venta(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }

    public function tipo_cuota(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TipoCuota::class);
    }

    public function cuotas() : \Illuminate\Database\Eloquent\Relations\HasMany{
        return $this->hasMany(Cuota::class);
    }

}
