<?php

use Illuminate\Support\Facades\Broadcast;


// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('message-channel',function(){
    return true;
});

Broadcast::event(SendMessage::class, function ($event) {
    return $event;
});
