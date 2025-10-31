<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Caja extends Model
{
    use HasFactory;
    protected $table = 'cajas';

    protected $fillable = [
        'user_id',
        'monto_inicial',
        'monto_cierre',
        'fecha_apertura',
        'fecha_cierre',
        'saldo_esperado',
        'diferencia',
        'egresos',
        'observaciones',
        'estado',
        'created_by',
        'updated_by',
    ];

    // En tu modelo Auditoria
    protected static function booted(): void
    {
        static::addGlobalScope('tenant_filter', function (Builder $builder) {
            if (auth()->check()) {
                $tenantId = auth()->user()->role === 'admin'
                    ? auth()->user()->id
                    : auth()->user()->tenant_id;

                $builder->where('cajas.tenant_id', $tenantId);
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movimientos()
    {
        return $this->hasMany(MovimientoCaja::class, 'caja_id');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function detallesVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'caja_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'caja_id');
    }
}
