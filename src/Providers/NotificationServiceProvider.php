<?php

namespace Juzaweb\Notification\Providers;

use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\Notification\NotificationAction;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\Notification\Repositories\SubscribeRepository;
use Juzaweb\Notification\Repositories\SubscribeRepositoryEloquent;

class NotificationServiceProvider extends ServiceProvider
{
    public array $bindings = [
        SubscribeRepository::class => SubscribeRepositoryEloquent::class,
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
