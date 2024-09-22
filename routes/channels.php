<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('reservations-channel', function ($user) {
    // \Log::info('User authorized for reservations-channel: ' . json_encode($user));
    return auth()->check(); // or any condition to authorize the user
});