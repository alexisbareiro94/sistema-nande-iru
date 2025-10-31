<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('admin-notificaciones.{tenantId}', function ($user, $tenantId) {
    return $user->role === 'admin' && $user->tenant_id == $tenantId;
});

Broadcast::channel('cierre-caja.{tenantId}', function ($user, $tenantId){
    return $user->role === 'admin' && $user->tenant_id == $tenantId;
});

//este evento no se usa
Broadcast::channel('logout', function($user){
    return $user->role == 'admin';
});

Broadcast::channel('auth-event.{tenantId}', function($user, $tenantId){
    return $user->role === 'admin' && $user->tenant_id == $tenantId;
});

Broadcast::channel('pdf-ready.{id}', function($user, $id){
    return (int) $user->id === (int) $id;
});

Broadcast::channel('ultima-actividad.{tenantId}', function($user, $tenantId){
    return $user->role === 'admin' && $user->tenant_id == $tenantId;
});

Broadcast::channel('auditoria-creada.{tenantId}', function($user, $tenantId){
    return $user->role === 'admin' && $user->tenant_id == (int)$tenantId;
});