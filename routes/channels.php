<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('admin-notificaciones', function ($user) {
    return $user->role == 'admin';
});

Broadcast::channel('cierre-caja', function ($user){
    return $user->role == 'admin';
});

//este evento no se usa
Broadcast::channel('logout', function($user){
    return $user->role == 'admin';
});

Broadcast::channel('auth-event', function($user){
    return $user->role == 'admin';
});

Broadcast::channel('pdf-ready.{id}', function($user, $id){
    return (int) $user->id === (int) $id;
});

Broadcast::channel('ultima-actividad', function($user){
    return $user->role === 'admin';
});