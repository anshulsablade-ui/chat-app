<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Events\Dispatcher;

class UpdateLastSeen
{
    /**
     * Handle user login.
     */
    public function handleUserLogin(Login $event): void
    {
        $event->user->forceFill([
            'is_online' => true,
            'last_seen' => now(),
        ])->save();
    }

    /**
     * Handle user logout.
     */
    public function handleUserLogout(Logout $event): void
    {
        if ($event->user) {
            $event->user->forceFill([
                'is_online' => false,
                'last_seen' => now(),
            ])->save();
        }
    }

    /**
     * Register event listeners.
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            Login::class,
            [self::class, 'handleUserLogin']
        );

        $events->listen(
            Logout::class,
            [self::class, 'handleUserLogout']
        );
    }
}
