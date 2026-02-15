<?php

namespace Juzaweb\Modules\Notification\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Juzaweb\Modules\Notification\Services\NotificationManager registerRecipientType(string $key, callable $callback)
 * @method static array<string, \Juzaweb\Modules\Notification\Contracts\RecipientTypeInterface> getRecipientTypes()
 * @method static array<string, array{label: string, description: string|null}> getRecipientTypesArray()
 * @method static \Juzaweb\Modules\Notification\Contracts\RecipientTypeInterface|null getRecipientType(string $key)
 * @method static bool hasRecipientType(string $key)
 * @method static \Juzaweb\Modules\Notification\Services\NotificationManager unregisterRecipientType(string $key)
 * @method static \Juzaweb\Modules\Notification\Services\NotificationManager registerChannel(string $key, callable $callback)
 * @method static array<string, \Juzaweb\Modules\Notification\Contracts\NotificationChannelInterface> getChannels()
 * @method static array<string, array{label: string, description: string|null}> getChannelsArray()
 * @method static bool hasChannel(string $key)
 * @method static \Juzaweb\Modules\Notification\Services\NotificationManager unregisterChannel(string $key)
 * @method static void subscriptable(string $channel, array $data = [])
 * @method static array<string> getSubscriptableChannels()
 * @method static array<string, mixed> getSubscriptableData(string $channel)
 *
 * @see \Juzaweb\Modules\Notification\Services\NotificationManager
 */
class Notification extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Juzaweb\Modules\Notification\Contracts\Notification::class;
    }
}
