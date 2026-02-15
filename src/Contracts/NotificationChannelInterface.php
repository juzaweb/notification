<?php

namespace Juzaweb\Modules\Notification\Contracts;

interface NotificationChannelInterface
{

    /**
     * Get the display label for the notification channel.
     *
     * @return string
     */
    public function getLabel(): string;

    /**
     * Get the description for the notification channel.
     *
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Convert the notification channel to an array.
     *
     * @return array{label: string, description: string|null}
     */
    public function toArray(): array;
}
