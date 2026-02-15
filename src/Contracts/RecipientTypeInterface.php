<?php

namespace Juzaweb\Modules\Notification\Contracts;

interface RecipientTypeInterface
{

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
     * Get the recipients query builder.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getRecipients(): \Illuminate\Database\Eloquent\Builder;

    /**
     * Convert the recipient type to an array.
     *
     * @return array{label: string, description: string|null}
     */
    public function toArray(): array;
}
