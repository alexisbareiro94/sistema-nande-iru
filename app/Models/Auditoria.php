<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $table = 'auditorias';

    protected $fillable = [
        'created_by',
        'entidad_type',
        'entidad_id',
        'accion',
        'datos',
    ];

    public function user()
    {
        return $this->belongsTo(User::class ,'created_by');
    }

    public function entidad()
    {
        return $this->morphTo();
    }    

    public function casts(): array
    {
        return [
            'datos' => 'array'
        ];
    }
}
