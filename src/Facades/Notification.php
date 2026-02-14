<?php

namespace Juzaweb\Modules\Notification\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Juzaweb\Modules\Notification\Services\NotificationManager registerRecipientType(\Juzaweb\Modules\Notification\Contracts\RecipientTypeInterface $recipientType)
 * @method static array<string, \Juzaweb\Modules\Notification\Contracts\RecipientTypeInterface> getRecipientTypes()
 * @method static array<string, array{key: string, label: string, description: string|null}> getRecipientTypesArray()
 * @method static \Juzaweb\Modules\Notification\Contracts\RecipientTypeInterface|null getRecipientType(string $key)
 * @method static bool hasRecipientType(string $key)
 * @method static \Juzaweb\Modules\Notification\Services\NotificationManager unregisterRecipientType(string $key)
 *
 * @see \Juzaweb\Modules\Notification\Services\NotificationManager
 */
class Notification extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'notification.manager';
    }
}
