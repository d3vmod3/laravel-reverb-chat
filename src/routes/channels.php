<?php

use Illuminate\Support\Facades\Broadcast;
// use Auth;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('message-channel', function ($user) {
    return Auth::check();
});