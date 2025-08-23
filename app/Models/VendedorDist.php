<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendedorDist extends Model
{
    protected $table = "vendedores_dist";
    protected $fillable = [
        'distribuidor_id',
        'nombre',
        'telefono',
        'email',
    ];

    public function distribuidor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Distribuidor::class);
    }
}
