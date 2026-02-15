<?php

namespace Juzaweb\Modules\Notification\Channels;

use NotificationChannels\Fcm\FcmChannel as BaseFcmChannel;
use Juzaweb\Modules\Notification\Contracts\NotificationChannelInterface;

class FcmChannel extends BaseFcmChannel implements NotificationChannelInterface
{
    public function getLabel(): string
    {
        return 'FCM';
    }

    public function getDescription(): ?string
    {
        return 'Send notifications via Firebase Cloud Messaging';
    }

    public function toArray(): array
    {
        return [
            'label' => $this->getLabel(),
            'description' => $this->getDescription(),
        ];
    }
}
