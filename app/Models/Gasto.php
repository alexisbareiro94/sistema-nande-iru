<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    protected $table = 'gastos';

    protected $fillable = [
        'user_id',
        'motivo',
        'cantidad',
        'fecha',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
