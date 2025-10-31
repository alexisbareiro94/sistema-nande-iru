<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PagoSalario extends Model
{
    // use BelongsToTenant;

    protected $table = 'pago_salarios';

    protected $fillable = [
        'user_id',
        'movimiento_id',
        'adelanto',
        'monto',
        'restante',
        'created_by'
    ];

    // En tu modelo Auditoria
    protected static function booted(): void
    {
        static::addGlobalScope('tenant_filter', function (Builder $builder) {
            if (auth()->check()) {
                $tenantId = auth()->user()->role === 'admin'
                    ? auth()->user()->id
                    : auth()->user()->tenant_id;

                $builder->where('pago_salarios.tenant_id', $tenantId);
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

    public function movimientos()
    {
        return $this->belongsTo(MovimientoCaja::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
