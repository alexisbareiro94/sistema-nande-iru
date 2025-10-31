<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Venta extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'ventas';

    protected $fillable = [
        'codigo',
        'caja_id',
        'cliente_id',
        'nro_ticket',
        'nro_factura',
        'cantidad_productos',
        'con_descuento',
        'monto_descuento',
        'forma_pago',
        'subtotal',
        'total',
        'estado',
        'created_by',
        'updated_by',
        'deleted_by',
        'vendedor_id',
    ];


    // En tu modelo Auditoria
    protected static function booted(): void
    {
        static::addGlobalScope('tenant_filter', function (Builder $builder) {
            if (auth()->check()) {
                $tenantId = auth()->user()->role === 'admin'
                    ? auth()->user()->id
                    : auth()->user()->tenant_id;

                $builder->where('ventas.tenant_id', $tenantId);
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
    public function cajero()
    {
        return $this->belongsTo(User::class, 'caja_id');
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'venta_id');
    }

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'caja_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'venta_id');
    }

    public function productos()
    {
        return $this->hasManyThrough(Producto::class, DetalleVenta::class, 'venta_id', 'id', 'id', 'producto_id');
    }

    public function movimiento()
    {
        return $this->belongsTo(MovimientoCaja::class, 'venta_id');
    }

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'vendedor_id');
    }
}
