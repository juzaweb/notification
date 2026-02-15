<?php

namespace Juzaweb\Modules\Notification\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Juzaweb\Modules\Notification\Contracts\Notification as NotificationManager;
use Juzaweb\Modules\Notification\Exceptions\RecipientTypeNotFoundException;
use Juzaweb\Modules\Notification\Models\SentNotification;
use Juzaweb\Modules\Notification\Notifications\Notifications;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected SentNotification $sentNotification;

    protected int $chunkSize;

    public int $timeout = 120; // Set a timeout for the job (in seconds)

    /**
     * Create a new job instance.
     *
     * @param SentNotification $sentNotification
     * @param int $chunkSize Number of recipients per chunk
     */
    public function __construct(SentNotification $sentNotification, int $chunkSize = 100)
    {
        $this->sentNotification = $sentNotification;
        $this->chunkSize = $chunkSize;
    }

    /**
     * Execute the job.
     *
     * @param NotificationManager $notificationManager
     * @return void
     */
    public function handle(NotificationManager $notificationManager): void
    {
        // Get the recipient type handler
        $recipientType = $notificationManager->getRecipientType(
            $this->sentNotification->recipient_type
        );

        if (!$recipientType) {
            throw RecipientTypeNotFoundException::forType(
                $this->sentNotification->recipient_type
            );
        }

        // Get recipients query
        $recipientsQuery = $recipientType->getRecipients();

        // Send notifications in chunks to avoid memory issues
        $recipientsQuery->chunk($this->chunkSize, function ($recipients) {
            Notification::send($recipients, new Notifications($this->sentNotification));
        });

        // Update sent_at timestamp after all notifications are sent
        $this->sentNotification->update([
            'sent_at' => now(),
        ]);
    }
}
