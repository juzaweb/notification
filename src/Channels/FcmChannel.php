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
            'apiKey' => 'API Key',
            'authDomain' => 'Auth Domain',
            'projectId' => 'Project ID',
            'storageBucket' => 'Storage Bucket',
            'messagingSenderId' => 'Messaging Sender ID',
            'appId' => 'App ID',
            'measurementId' => 'Measurement ID (Optional)',
        ];
    }
}
