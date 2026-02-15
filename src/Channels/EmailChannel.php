<?php

namespace Juzaweb\Modules\Notification\Channels;

use Juzaweb\Modules\Notification\Contracts\NotificationChannelInterface;

class EmailChannel implements NotificationChannelInterface
{
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
}
