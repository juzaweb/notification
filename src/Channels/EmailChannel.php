<?php

namespace Juzaweb\Modules\Notification\Channels;

use Illuminate\Notifications\Channels\MailChannel;
use Juzaweb\Modules\Notification\Contracts\NotificationChannelInterface;

class EmailChannel implements NotificationChannelInterface
{
    public function getChannel(): string
    {
        return MailChannel::class;
    }

    public function getLabel(): string
    {
        return 'Email';
    }

    public function getDescription(): ?string
    {
        return 'Send notifications via email';
    }

    public function toArray(): array
    {
        return [
            'label' => $this->getLabel(),
            'description' => $this->getDescription(),
        ];
    }

    public function getConfig(): array
    {
        return [];
    }
}
