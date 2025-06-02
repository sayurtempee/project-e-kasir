<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class SetUserStatusActive
{
    public function handle(Login $event)
    {
        $user = $event->user;
        $user->status = 'aktif';
        $user->save();
    }
}
