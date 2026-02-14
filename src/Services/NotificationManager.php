<?php

namespace Juzaweb\Modules\Notification\Services;

use Juzaweb\Modules\Notification\Contracts\RecipientTypeInterface;

class NotificationManager
{
    /**
     * Registered recipient types.
     *
     * @var array<string, RecipientTypeInterface>
     */
    protected array $recipientTypes = [];

    /**
     * Register a new recipient type.
     *
     * @param RecipientTypeInterface $recipientType The recipient type instance
     * @return self
     */
    public function registerRecipientType(RecipientTypeInterface $recipientType): self
    {
        $this->recipientTypes[$recipientType->getKey()] = $recipientType;

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
     * @return array<string, array{key: string, label: string, description: string|null}>
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
}
