<?php

namespace App\Providers;

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
        parent::boot();
        //
    }

    public function shouldDiscoverEvents()
    {
        return true;
    }

    protected function discoverEventsWithin()
    {
        $discovered_directories = [];
        foreach (scandir($path = app_path('Modules')) as $dir) {
            if (file_exists($folder_path = "{$path}/{$dir}/Core/Application/EventListener")) {
                $discovered_directories[] = $folder_path;
            }
        }

        return array_merge(parent::discoverEventsWithin(), $discovered_directories);
    }
}
