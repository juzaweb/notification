<?php

namespace Juzaweb\Modules\Notification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification as BaseNotification;
use Illuminate\Support\Traits\Macroable;
use Juzaweb\Modules\Notification\Contracts\Notification as ContractsNotification;
use Juzaweb\Modules\Notification\Models\SentNotification;

class Notification extends BaseNotification implements ShouldQueue
{
    use Queueable, Macroable;

    protected SentNotification $sentNotification;

    public function __construct(SentNotification $sentNotification)
    {
        $this->sentNotification = $sentNotification;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = $this->sentNotification->via;
        $manager = app(ContractsNotification::class);

        return collect($channels)->map(function ($key) use ($manager) {
            if ($manager->hasChannel($key)) {
                return $manager->getChannels()[$key];
            }

            return $key;
        })->toArray();
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->sentNotification->title)
            ->text($this->sentNotification->message);
    }

    /**
     * Get the SentNotification instance.
     *
     * @return SentNotification
     */
    public function getSentNotification(): SentNotification
    {
        return $this->sentNotification;
    }
}
