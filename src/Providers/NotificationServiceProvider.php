<?php

namespace Juzaweb\Notification\Providers;

use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\Notification\NotificationAction;
use Juzaweb\CMS\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        ActionRegister::register([NotificationAction::class]);
    }

    public function register(): void
    {
        //
    }
}
