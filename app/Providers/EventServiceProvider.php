<?php

namespace App\Providers;

use App\Events\RequireNewFacebookFeeds;
use App\Events\NewEventCreated;
use App\Events\NewPostCreated;
use App\Events\NotificationEvent;
use App\Events\UserApprovedEvent;
use App\Listeners\AddEventToStream;
use App\Listeners\AddPostToStream;
use App\Listeners\CreateNewNotification;
use App\Listeners\SendNewPostEmailNotification;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent'         => [
            'App\Listeners\EventListener',
        ],
        NotificationEvent::class       => [
            CreateNewNotification::class
        ],
        NewPostCreated::class          => [
            SendNewPostEmailNotification::class,
            AddPostToStream::class,
        ],
        NewEventCreated::class         => [
            AddEventToStream::class,
        ],
        RequireNewFacebookFeeds::class => [
            "App\Listeners\FetchFacebookFeeds",
        ],
        UserApprovedEvent::class => [
            "App\Listeners\SendConfirmationEmailToUser",
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
