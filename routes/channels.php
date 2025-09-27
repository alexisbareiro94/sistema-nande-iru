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