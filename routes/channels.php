<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    // Izinkan user untuk mendengarkan channel ini HANYA JIKA
    // ID user yang sedang login sama dengan ID yang ada di nama channel.
    return (int) $user->id === (int) $id;
});
