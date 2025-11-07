<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    protected static function booted(): void
    {
        static::addGlobalScope('tenant_filter', function (Builder $builder) {
            if (auth()->check()) {
                $tenantId = auth()->user()->role === 'admin'
                    ? auth()->user()->id
                    : auth()->user()->tenant_id;

                $builder->where('auditorias.tenant_id', $tenantId);
            }
        });
    }

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
        return $this->belongsTo(User::class, 'created_by');
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
