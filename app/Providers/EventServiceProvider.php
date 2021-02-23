<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        \App\Models\Category::observe(\App\Observers\CategoryObserver::class);
        \App\Models\Post::observe(\App\Observers\PostObserver::class);
        \App\Models\Role::observe(\App\Observers\RoleObserver::class);
        \App\Models\Tag::observe(\App\Observers\TagObserver::class);
        \App\Models\User::observe(\App\Observers\UserObserver::class);
    }
}
