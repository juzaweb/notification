<?php

namespace Juzaweb\Notification\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Juzaweb\Facades\HookAction;
use Juzaweb\Notification\Commands\SendNotify;
use Juzaweb\Notification\Notification;
use Juzaweb\Notification\Notifications\DatabaseNotification;
use Juzaweb\Notification\Notifications\EmailNotification;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootCommands();
        HookAction::loadActionForm(__DIR__ . '/../../actions');

        Notification::register('database', DatabaseNotification::class);
        Notification::register('mail', EmailNotification::class);
    }

    public function register()
    {
        $this->registerCommands();
        $this->app->register(RouteServiceProvider::class);
    }

    protected function bootCommands()
    {
        $schedule = $this->app->make(Schedule::class);
        $schedule->command('notify:send')->everyMinute();
    }

    protected function registerCommands()
    {
        $this->commands([
            SendNotify::class,
        ]);
    }
}
