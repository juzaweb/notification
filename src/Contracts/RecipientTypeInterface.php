<?php

namespace Juzaweb\Modules\Notification\Contracts;

interface RecipientTypeInterface
{
    /**
     * Get the unique key for the recipient type.
     *
     * @return string
     */
    public function getKey(): string;

    /**
     * Get the display label for the recipient type.
     *
     * @return string
     */
    public function getLabel(): string;

    /**
     * Get the description for the recipient type.
     *
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Convert the recipient type to an array.
     *
     * @return array{key: string, label: string, description: string|null}
     */
    public function toArray(): array;
}
