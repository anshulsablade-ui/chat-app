<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Auth;

class UpdateLastSeen
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle user login events.
     */

    public function handleUserLogin(Login $event): void
    {
    }

    /**
     * Handle user logout events.
     */
    public function handleUserLogout(Logout $event): void
    {
        if (Auth::check()) {
            Auth::user()->update([
                'last_seen' => now()
            ]);
        }
    }

        /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            Login::class,
            [UpdateLastSeen::class, 'handleUserLogin']
        );
 
        $events->listen(
            Logout::class,
            [UpdateLastSeen::class, 'handleUserLogout']
        );
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        //
    }
}
