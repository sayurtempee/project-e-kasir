<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class UpdateUserStatus
{
    // Saat login
    public function handleLogin(Login $event)
    {
        $user = $event->user;
        $user->status = 'aktif';
        $user->save();
    }

    // Saat logout
    public function handleLogout(Logout $event)
    {
        $user = $event->user;
        if ($user) {
            $user->status = 'tidak aktif';
            $user->save();
        }
    }

    // Daftarkan event-event yang dipantau
    public function subscribe($events)
    {
        $events->listen(
            Login::class,
            [UpdateUserStatus::class, 'handleLogin']
        );

        $events->listen(
            Logout::class,
            [UpdateUserStatus::class, 'handleLogout']
        );
    }
}
