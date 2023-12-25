<?php

namespace Juzaweb\Notification\Models;

use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Traits\ResourceModel;

class Subscribe extends Model
{
    use ResourceModel;

    protected $table = 'jw_notification_subscribes';

    protected $fillable = [
        'name',
        'email',
    ];
}
