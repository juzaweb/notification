<?php

namespace Juzaweb\Modules\Notification\Models;

use Juzaweb\Modules\Core\Models\Model;
use Juzaweb\Modules\Core\Traits\HasAPI;

class ChannelConfig extends Model
{
    use HasAPI;

    protected $table = 'channel_configs';

    protected $fillable = [
        'channel_key',
        'config',
    ];

    protected $casts = [
        'config' => 'array',
    ];
}
