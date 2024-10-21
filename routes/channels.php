<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('balance.{id}', function ($user, $id) {
    return (int) $id === (int) $user->id;
});

Broadcast::channel('Balance.Operation.{id}', function ($user, $id) {
    return (int) $id === (int) $user->id;
});
