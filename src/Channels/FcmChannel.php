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
            'config' => $this->getConfig(),
        ];
    }

    public function getConfig(): array
    {
        return [
            'server_key' => 'Server Key',
            'sender_id' => 'Sender ID',
        ];
    }
}
