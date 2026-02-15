<?php

namespace Juzaweb\Modules\Notification\Services;

use Juzaweb\Modules\Notification\Contracts\Notification;
use Juzaweb\Modules\Notification\Contracts\NotificationChannelInterface;
use Juzaweb\Modules\Notification\Contracts\RecipientTypeInterface;

class NotificationManager implements Notification
{
    /**
     * Registered recipient types.
     *
     * @var array<string, RecipientTypeInterface>
     */
    protected array $recipientTypes = [];

    /**
     * @var array <string, array<string, mixed>>
     */
    protected array $subscriptableChannels = [];

    /**
     * Registered notification channels.
     *
     * @var array<string, NotificationChannelInterface>
     */
    protected array $channels = [];

    /**
     * Register a new recipient type.
     *
     * @param string $key The recipient type key
     * @param callable $callback Callback that returns RecipientTypeInterface instance
     * @return self
     */
    public function registerRecipientType(string $key, callable $callback): self
    {
        $this->recipientTypes[$key] = $callback();

        return $this;
    }

    /**
     * Get all registered recipient types.
     *
     * @return array<string, RecipientTypeInterface>
     */
    public function getRecipientTypes(): array
    {
        return $this->recipientTypes;
    }

    /**
     * Get all registered recipient types as array.
     *
     * @return array<string, array{label: string, description: string|null}>
     */
    public function getRecipientTypesArray(): array
    {
        return array_map(fn($type) => $type->toArray(), $this->recipientTypes);
    }

    /**
     * Get a specific recipient type by key.
     *
     * @param string $key
     * @return RecipientTypeInterface|null
     */
    public function getRecipientType(string $key): ?RecipientTypeInterface
    {
        return $this->recipientTypes[$key] ?? null;
    }

    /**
     * Check if a recipient type is registered.
     *
     * @param string $key
     * @return bool
     */
    public function hasRecipientType(string $key): bool
    {
        return isset($this->recipientTypes[$key]);
    }

    /**
     * Unregister a recipient type.
     *
     * @param string $key
     * @return self
     */
    public function unregisterRecipientType(string $key): self
    {
        unset($this->recipientTypes[$key]);

        return $this;
    }

    /**
     * @param string $channel
     * @param array<string, mixed> $options
     * @return void
     */
    public function subscriptable(string $channel, array $data = []): void
    {
        $this->subscriptableChannels[$channel] = $data;
    }

    /**
     * Get subscriptable channels.
     *
     * @return array<string>
     */
    public function getSubscriptableChannels(): array
    {
        return array_keys($this->subscriptableChannels);
    }

    /**
     * Get subscriptable data.
     *
     * @param string $channel
     * @return array<string, mixed>
     */
    public function getSubscriptableData(string $channel): array
    {
        return $this->subscriptableChannels[$channel] ?? [];
    }

    /**
     * Register a notification channel.
     *
     * @param string $key Channel identifier
     * @param callable $callback Callback that returns NotificationChannelInterface instance
     * @return self
     */
    public function registerChannel(string $key, callable $callback): self
    {
        $this->channels[$key] = $callback();

        return $this;
    }

    /**
     * Get all registered channels.
     *
     * @return array<string, NotificationChannelInterface>
     */
    public function getChannels(): array
    {
        return $this->channels;
    }

    /**
     * Get all registered channels as array.
     *
     * @return array<string, array{label: string, description: string|null}>
     */
    public function getChannelsArray(): array
    {
        return array_map(fn($channel) => $channel->toArray(), $this->channels);
    }

    /**
     * Check if a channel is registered.
     *
     * @param string $key
     * @return bool
     */
    public function hasChannel(string $key): bool
    {
        return isset($this->channels[$key]);
    }

    /**
     * Unregister a channel.
     *
     * @param string $key
     * @return self
     */
    public function unregisterChannel(string $key): self
    {
        unset($this->channels[$key]);

        return $this;
    }
}
