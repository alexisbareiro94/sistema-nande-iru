<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class VendedorDist extends Model
{
    // use BelongsToTenant;

    protected $table = "vendedores_dist";

    protected $fillable = [
        'distribuidor_id',
        'nombre',
        'telefono',
        'email',
    ];
    // En tu modelo Auditoria
    public function scopeForCurrentTenant($query)
    {
        if (auth()->check()) {
            $tenantId = auth()->user()->role === 'admin'
                ? auth()->user()->id
                : auth()->user()->tenant_id;

            return $query->where('tenant_id', $tenantId);
        }

        return $query;
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
    public function distribuidor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Distribuidor::class);
    }
}
