<?php

namespace Juzaweb\Modules\Notification\Models;

use Juzaweb\Modules\Core\Models\Model;
use Juzaweb\Modules\Core\Traits\HasAPI;

class SentNotifications extends Model
{
    use HasAPI;

    protected $table = 'sent_notifications';

    protected $fillable = [];
}
