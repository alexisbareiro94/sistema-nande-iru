<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'subtotal',
        'total',
        'estado',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

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
}
