<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Producto extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'productos';
    protected $fillable = [
        'nombre',
        'codigo',
        'tipo',
        'descripcion',
        'precio_compra',
        'precio_venta',
        'stock',
        'stock_minimo',
        'categoria_id',
        'marca_id',
        'distribuidor_id',
        'ventas',
        'imagen',
    ];

    // En tu modelo Auditoria
    protected static function booted(): void
    {
        static::addGlobalScope('tenant_filter', function (Builder $builder) {
            if (auth()->check()) {
                $tenantId = auth()->user()->role === 'admin'
                    ? auth()->user()->id
                    : auth()->user()->tenant_id;

                $builder->where('productos.tenant_id', $tenantId);
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

    public function categoria(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function marca(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Marca::class);
    }

    public function distribuidor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Distribuidor::class);
    }

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'producto_id');
    }

    public function ultima_venta()
    {
        return $this->hasOne(DetalleVenta::class, 'producto_id')->latest('created_at');
    }
}
