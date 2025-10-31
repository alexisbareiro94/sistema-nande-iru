<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Distribuidor extends Model
{
    // use BelongsToTenant;

    protected $table = 'distribuidores';

    protected $fillable = [
        'nombre',
        'ruc',
        'celular',
        'direccion',
    ];

    // En tu modelo Auditoria
     protected static function booted(): void
    {
        static::addGlobalScope('tenant_filter', function (Builder $builder) {
            if (auth()->check()) {
                $tenantId = auth()->user()->role === 'admin'
                    ? auth()->user()->id
                    : auth()->user()->tenant_id;

                $builder->where('distribuidores.tenant_id', $tenantId);
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
    public function vendedores()
    {
        return $this->hasMany(VendedorDist::class, 'distribuidor_id');
    }
}
