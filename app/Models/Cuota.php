<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    protected $table = 'cuotas';
    protected $fillable = [
        'plan_cuota_id',
        'nro_cuota',
        'monto_cuota',
        'monto_pagado',
        'fecha_vencimiento',
        'estado',
        'fecha_pago'
    ];
    public function plan_cuota(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PlanCuota::class);
    }
}
