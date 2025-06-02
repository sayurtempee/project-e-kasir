<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\SetUserStatusActive;
use App\Listeners\SetUserStatusInactive;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            SetUserStatusActive::class,
        ],
        Logout::class => [
            SetUserStatusInactive::class,
        ],
    ];

    public function boot()
    {
        //
    }
}
