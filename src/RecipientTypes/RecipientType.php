<?php

namespace Juzaweb\Modules\Notification\RecipientTypes;

use Juzaweb\Modules\Notification\Contracts\RecipientTypeInterface;

class RecipientType implements RecipientTypeInterface
{
    protected string $key;
    protected string $label;
    protected ?string $description;

    public function __construct(string $key, string $label, ?string $description = null)
    {
        $this->key = $key;
        $this->label = $label;
        $this->description = $description;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'label' => $this->label,
            'description' => $this->description,
        ];
    }
}
