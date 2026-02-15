<?php

namespace Juzaweb\Modules\Notification\Channels;

use NotificationChannels\Fcm\FcmChannel as BaseFcmChannel;
use Juzaweb\Modules\Notification\Contracts\NotificationChannelInterface;

class FcmChannel implements NotificationChannelInterface
{
    public function getChannel(): string
    {
        return BaseFcmChannel::class;
    }

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
