<?php

namespace Juzaweb\Modules\Notification\RecipientTypes;

use Illuminate\Database\Eloquent\Builder;
use Juzaweb\Modules\Core\Models\User;
use Juzaweb\Modules\Notification\Contracts\RecipientTypeInterface;

class AllUsersRecipientType implements RecipientTypeInterface
{
    public function getLabel(): string
    {
        return __('All Users');
    }

    public function getDescription(): ?string
    {
        return __('Send notification to all registered users');
    }

    public function getRecipients(): Builder
    {
        return User::query();
    }

    public function toArray(): array
    {
        return [
            'label' => $this->getLabel(),
            'description' => $this->getDescription(),
        ];
    }
}
