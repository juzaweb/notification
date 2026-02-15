<?php

namespace Juzaweb\Modules\Notification\Providers;

use Juzaweb\Modules\Core\Facades\Menu;
use Juzaweb\Modules\Core\Providers\ServiceProvider;
use Juzaweb\Modules\Notification\Contracts\Notification;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerMenus();
        $this->registerRecipientTypes();
        $this->registerChannels();
    }

    public function register(): void
    {
        $this->registerNotificationManager();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->app->register(RouteServiceProvider::class);
    }

    protected function registerNotificationManager(): void
    {
        $this->app->singleton(Notification::class, function ($app) {
            return new \Juzaweb\Modules\Notification\Services\NotificationManager();
        });
    }

    protected function registerMenus(): void
    {
        Menu::make('notifications-management', function () {
            return [
                'title' => __('Notifications'),
            ];
        });

        Menu::make('sent-notifications', function () {
            return [
                'title' => __('Sent Notifications'),
                'parent' => 'notifications-management'
            ];
        });

        Menu::make('notifications.channels', function () {
            return [
                'title' => __('Channels'),
                'parent' => 'notifications-management',
                'url' => 'channel-configs',
            ];
        });
    }

    protected function registerRecipientTypes(): void
    {
        $notification = app(Notification::class);

        $notification->registerRecipientType('all_users', function () {
            return new \Juzaweb\Modules\Notification\RecipientTypes\AllUsersRecipientType();
        });
    }

    protected function registerChannels(): void
    {
        $notification = app(Notification::class);

        $notification->registerChannel('email', function () {
            return app(\Juzaweb\Modules\Notification\Channels\EmailChannel::class);
        });

        $notification->registerChannel('fcm', function () {
            return app(\Juzaweb\Modules\Notification\Channels\FcmChannel::class);
        });
    }

    protected function registerConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/notification.php' => config_path('notification.php'),
        ], 'notification-config');
        $this->mergeConfigFrom(__DIR__ . '/../../config/notification.php', 'notification');
    }

    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'notification');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../resources/lang');
    }

    protected function registerViews(): void
    {
        $viewPath = resource_path('views/modules/notification');

        $sourcePath = __DIR__ . '/../resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', 'notification-module-views']);

        $this->loadViewsFrom($sourcePath, 'notification');
    }
}
