<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;
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

    public function categoria(): \Illuminate\Database\Eloquent\Relations\BelongsTo{
        return $this->belongsTo(Categoria::class);
    }

    public function marca(): \Illuminate\Database\Eloquent\Relations\BelongsTo{
        return $this->belongsTo(Marca::class);
    }

    public function ventas(): \Illuminate\Database\Eloquent\Relations\HasMany{
        return $this->hasMany(Venta::class, 'producto_id');
    }

    public function distribuidor():\Illuminate\Database\Eloquent\Relations\BelongsTo{
        return $this->belongsTo(Distribuidor::class);
    }
}
