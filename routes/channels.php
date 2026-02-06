<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    return true;
});

Broadcast::channel('online', function ($user) { 
    // dd($user);
    return [
        'id' => $user->id,
        'name' => $user->name,
    ];
});

// Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
//     cache()->put("user-online-{$user->id}", true, now()->addMinutes(2));
//     return $user->conversations()->where('id', $conversationId)->exists();
// });

