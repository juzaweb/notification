<?php

namespace Juzaweb\Notification\Models;

use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Traits\ResourceModel;
use Juzaweb\CMS\Traits\UseUUIDColumn;

class EmailSubscribe extends Model
{
    use ResourceModel, UseUUIDColumn;

    protected $table = 'jw_notification_email_subscribes';

    protected $fillable = [
        'name',
        'email',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function getFieldName(): string
    {
        return 'email';
    }
}
