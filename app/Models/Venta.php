<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'user_id',
        'fecha',
        'total',
        'estado',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
