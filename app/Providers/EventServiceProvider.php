<?php

namespace App\Providers;

use Amentotech\LaraGuppy\Events\GuppyChatPrivateEvent;
use App\Listeners\MessageReceivedListener;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Profile;
use App\Observers\BlogCategoryObserver;
use App\Observers\BlogObserver;
use App\Observers\ProfileObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        GuppyChatPrivateEvent::class => [
            MessageReceivedListener::class
        ]
    ];

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        Profile::class              => [ProfileObserver::class],
        Blog::class                 => [BlogObserver::class],
        BlogCategory::class         => [BlogCategoryObserver::class],
    ];


    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
