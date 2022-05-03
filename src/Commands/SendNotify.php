<?php

namespace Juzaweb\Notification\Commands;

use Illuminate\Console\Command;
use Juzaweb\Backend\Models\ManualNotification;
use Juzaweb\CMS\Support\SendNotification;

class SendNotify extends Command
{
    protected $signature = 'notify:send';

    protected int $limit = 5;

    public function handle()
    {
        if (config('notification.method') != 'cron') {
            return;
        }

        $count = 0;
        while ($count < $this->limit) {
            $notification = ManualNotification::withoutGlobalScopes()
                ->where('status', '=', 2)
                ->first();

            if (empty($notification)) {
                break;
            }

            if ((new SendNotification($notification))->send()) {
                $this->info('Send notify successful: ' . $notification->id);
            } else {
                $this->error('Send notify error: ' . $notification->id);
            }

            $count ++;
        }
    }
}
