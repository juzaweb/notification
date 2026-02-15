<?php

namespace Juzaweb\Modules\Notification\Contracts;

interface NotificationChannelInterface
{
    /**
     * Get the Laravel notification channel class name.
     *
     * @return string
     */
    public function getChannel(): string;

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

    /**
     * Get configuration fields for this channel.
     *
     * @return array<string, string> Array of config field keys and labels
     */
    public function getConfig(): array;
}
