<?php

namespace Juzaweb\Notification\Providers;

use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\Notification\NotificationAction;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\Notification\Repositories\EmailSubscribeRepository;
use Juzaweb\Notification\Repositories\EmailSubscribeRepositoryEloquent;

class NotificationServiceProvider extends ServiceProvider
{
    public array $bindings = [
        EmailSubscribeRepository::class => EmailSubscribeRepositoryEloquent::class,
    ];

    public function boot(): void
    {
        ActionRegister::register([NotificationAction::class]);
    }

    public function register(): void
    {
        //
    }
}
