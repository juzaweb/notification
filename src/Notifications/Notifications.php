<?php

namespace Juzaweb\Modules\Notification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification as BaseNotification;
use Juzaweb\Modules\Notification\Contracts\Notification as ContractsNotification;
use Juzaweb\Modules\Notification\Models\SentNotification;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotificationResource;

class Notifications extends BaseNotification implements ShouldQueue
{
    use Queueable;

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
        $manager = app(ContractsNotification::class);

        $channels = collect($this->sentNotification->via)->map(function ($key) use ($manager) {
            if ($manager->hasChannel($key)) {
                return get_class($manager->getChannels()[$key]);
            }

            return $key;
        })->toArray();

        $channels[] = 'database';

        return $channels;
    }

    public function toMail($notifiable)
    {
        $lines = explode("\n", $this->sentNotification->message);

        $msg = (new MailMessage)->subject($this->sentNotification->title);

        foreach ($lines as $line) {
            $msg->line($line);
        }

        return $msg;
    }

    public function toFcm($notifiable): FcmMessage
    {
        return (new FcmMessage)->notification(
            (new FcmNotificationResource())
            ->title($this->sentNotification->title)
            ->body($this->sentNotification->message)
        );
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

    public function toArray()
    {
        return [
            'title' => $this->sentNotification->title,
            'message' => $this->sentNotification->message,
        ];
    }
}
