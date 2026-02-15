<?php

namespace Juzaweb\Modules\Notification\Exceptions;

use Exception;

class RecipientTypeNotFoundException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param string $recipientType
     * @return static
     */
    public static function forType(string $recipientType): self
    {
        return new self("Recipient type '{$recipientType}' not found");
    }
}
