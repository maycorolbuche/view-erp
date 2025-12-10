<?php

namespace App\Listeners;

use Illuminate\Notifications\Events\NotificationSent;
use App\Models\NotificationLog;
use Illuminate\Support\Facades\Log;

class LogSentNotification
{
    public function handle(NotificationSent $event)
    {
        $notification = $event->notification;
        $notifiable = $event->notifiable;
        $channel = $event->channel;
        $response = $event->response;

        // Criar log no banco de dados
        NotificationLog::create([
            'notification_type' => get_class($notification),
            'notifiable_type' => get_class($notifiable),
            'notifiable_id' => $notifiable->id,
            'channel' => $channel,
            'data' => json_encode([
                'data' => $notification->data ?? null,
                'type' => $notification->type ?? null,
                'response' => $response,
            ]),
            'sent_at' => now(),
        ]);
    }
}
