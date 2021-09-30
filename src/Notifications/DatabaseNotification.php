<?php

namespace Juzaweb\Notification\Notifications;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Juzaweb\Notification\Models\Notification;

class DatabaseNotification extends NotificationAbstract
{
    public function handle()
    {
        foreach ($this->users as $user) {
            Notification::create([
                'id' => (string) Str::uuid(),
                'type' => 'Juzaweb\Notification\Notifications\DbNotify',
                'data' => [
                    'subject' => Arr::get($this->notification->data, 'subject'),
                    'body' => Arr::get($this->notification->data, 'body'),
                    'url' => Arr::get($this->notification->data, 'url'),
                    'image' => Arr::get($this->notification->data, 'image'),
                ],
                'notifiable_type' => 'Juzaweb\Models\User',
                'notifiable_id' => $user
            ]);
        }
    }
}
