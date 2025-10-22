<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distribuidor extends Model
{
    protected $table = 'distribuidores';

    protected $fillable = [
        'nombre',
        'ruc',
        'celular',
        'direccion',
    ];

    public function vendedores()
    {
        return $this->hasMany(VendedorDist::class, 'distribuidor_id');
    }
}
