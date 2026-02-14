<?php

namespace Juzaweb\Modules\Notification\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Juzaweb\Modules\Core\Models\Model;
use Juzaweb\Modules\Core\Traits\HasAPI;

class SentNotification extends Model
{
    use HasAPI, HasUuids;

    protected $table = 'sent_notifications';

    protected $fillable = [
        'title',
        'message',
        'recipient_type',
        'via',
        'sent_at',
    ];

    protected $casts = [
        'via' => 'array',
        'sent_at' => 'datetime',
    ];
}
