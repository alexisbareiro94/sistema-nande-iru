<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleVenta extends Model
{
    use SoftDeletes;

    protected $table = 'detalle_ventas';

    protected $fillable = [
    'venta_id',
    'producto_id',
    'cantidad',
    'precio_unitario',
    'producto_con_descuento',
    'monto_descuento',
    'subtotal',
    'precio_venta',
    'created_by',
    'updated_by',
    'deleted_by',
];


    public function venta(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }

    public function producto(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
}
