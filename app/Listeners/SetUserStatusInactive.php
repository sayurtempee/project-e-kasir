<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;

class SetUserStatusInactive
{
    public function handle(Logout $event)
    {
        $user = $event->user;
        if ($user) {
            $user->status = 'tidak aktif';
            $user->save();
        }
    }
}
