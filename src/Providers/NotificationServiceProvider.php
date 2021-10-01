<?php

namespace Juzaweb\Notification\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Juzaweb\Notification\Actions\MainAction;
use Juzaweb\Support\ServiceProvider;
use Juzaweb\Notification\Commands\SendNotify;
use Juzaweb\Notification\Notification;
use Juzaweb\Notification\Notifications\DatabaseNotification;
use Juzaweb\Notification\Notifications\EmailNotification;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootCommands();
        Notification::register('database', DatabaseNotification::class);
        Notification::register('mail', EmailNotification::class);

        $this->registerAction([
            MainAction::class
        ]);
    }

    public function register()
    {
        $this->registerCommands();
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
