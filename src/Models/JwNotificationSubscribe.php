<?php

namespace Juzaweb\Notification\Models;

use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Traits\ResourceModel;

class JwNotificationSubscribe extends Model
{
    use ResourceModel;

    protected $table = 'jw_notification_subscribes';

    protected $fillable = [
    'name',
    'email',
    'user_id'
];
}
