<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Cuota extends Model
{
    // use BelongsToTenant;

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

     protected static function booted(): void
    {
        static::addGlobalScope('tenant_filter', function (Builder $builder) {
            if (auth()->check()) {
                $tenantId = auth()->user()->role === 'admin'
                    ? auth()->user()->id
                    : auth()->user()->tenant_id;

                $builder->where('cuotas.tenant_id', $tenantId);
            }
        });
    }


    // En tu modelo Producto
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->tenant_id && auth()->check()) {
                $model->tenant_id = auth()->user()->role === 'admin'
                    ? auth()->user()->id
                    : auth()->user()->tenant_id;
            }
        });
    }

    public function plan_cuota(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PlanCuota::class);
    }
}
