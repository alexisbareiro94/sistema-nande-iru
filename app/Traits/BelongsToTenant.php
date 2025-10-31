<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToTenant
{
    public static function bootBelongsToTenant(): void
    {
        static::creating(function ($model) {
            if (!$model->tenant_id && auth()->check()) {
                $tenantId = auth()->user()->role == 'admin' 
                    ? auth()->user()->id 
                    : auth()->user()->tenant_id;
                $model->tenant_id = $tenantId;
            }
        });

        static::addGlobalScope('tenant', function (Builder $builder) {
            // Solo aplicar el scope si hay usuario autenticado
            if (auth()->check()) {
                $user = auth()->user();
                
                // No aplicar el scope para admins (opcional)
                // if ($user->role === 'admin') {
                //     return;
                // }
                
                $tenantId = $user->role == 'admin' 
                    ? $user->id 
                    : $user->tenant_id;
                
                // Verificar que el tenant_id no sea null
                if ($tenantId) {
                    $builder->where('tenant_id', $tenantId);
                }
            }
        });
    }
}