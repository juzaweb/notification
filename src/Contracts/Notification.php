<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 */

namespace Juzaweb\Modules\Notification\Contracts;

interface Notification
{
    /**
     * Register a new recipient type.
     *
     * @param string $key
     * @param callable $callback
     * @return self
     */
    public function registerRecipientType(string $key, callable $callback): self;

    /**
     * Get all registered recipient types.
     *
     * @return array<string, RecipientTypeInterface>
     */
    public function getRecipientTypes(): array;

    /**
     * Get all registered recipient types as array.
     *
     * @return array<string, array{label: string, description: string|null}>
     */
    public function getRecipientTypesArray(): array;

    /**
     * Get a specific recipient type by key.
     *
     * @param string $key
     * @return RecipientTypeInterface|null
     */
    public function getRecipientType(string $key): ?RecipientTypeInterface;

    /**
     * Check if a recipient type is registered.
     *
     * @param string $key
     * @return bool
     */
    public function hasRecipientType(string $key): bool;

    /**
     * Unregister a recipient type.
     *
     * @param string $key
     * @return self
     */
    public function unregisterRecipientType(string $key): self;

    /**
     * Register a notification channel.
     *
     * @param string $key
     * @param callable $callback
     * @return self
     */
    public function registerChannel(string $key, callable $callback): self;

    /**
     * Get all registered channels.
     *
     * @return array<string, NotificationChannelInterface>
     */
    public function getChannels(): array;

    /**
     * Get all registered channels as array.
     *
     * @return array<string, array{label: string, description: string|null}>
     */
    public function getChannelsArray(): array;

    /**
     * Check if a channel is registered.
     *
     * @param string $key
     * @return bool
     */
    public function hasChannel(string $key): bool;

    /**
     * Unregister a channel.
     *
     * @param string $key
     * @return self
     */
    public function unregisterChannel(string $key): self;

    /**
     * Mark a channel as subscriptable.
     *
     * @param string $channel
     * @param array<string, mixed> $data
     * @return void
     */
    public function subscriptable(string $channel, array $data = []): void;

    /**
     * Get all subscriptable channels.
     *
     * @return array<string>
     */
    public function getSubscriptableChannels(): array;

    /**
     * Get subscriptable data for a specific channel.
     *
     * @param string $channel
     * @return array<string, mixed>
     */
    public function getSubscriptableData(string $channel): array;
}
