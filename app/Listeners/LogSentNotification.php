<?php

namespace App\Listeners;

use Illuminate\Notifications\Events\NotificationSent;
use App\Models\NotificationLog;

class LogSentNotification
{
    public function handle(NotificationSent $event)
    {
        $notification = $event->notification;
        $notifiable = $event->notifiable;
        $channel = $event->channel;
        $response = $event->response;

        $recipient = $this->getRecipient($notifiable, $notification);
        $subject = $this->getSubject($notification, $notifiable);
        $message = $this->getMessageContent($notification, $notifiable);

        // Criar log no banco de dados
        NotificationLog::create([
            'notification_type' => get_class($notification),
            'notifiable_type' => get_class($notifiable),
            'id_user' => $notifiable->id_user,
            'recipient' => $recipient,
            'subject' => $subject,
            'message' => $message,
            'channel' => $channel,
            'data' => $notification->data ?? null,
            'type' => $notification->type ?? null,
            'response' => $response,
            'sent_at' => now(),
        ]);
    }

    protected function getRecipient($notifiable, $notification)
    {
        // Tentar várias formas de obter o email
        if (method_exists($notifiable, 'routeNotificationForMail')) {
            return $notifiable->routeNotificationForMail($notification);
        }

        if (method_exists($notifiable, 'routeNotificationFor')) {
            return $notifiable->routeNotificationFor('mail', $notification);
        }

        if (isset($notifiable->email)) {
            return $notifiable->email;
        }

        if (isset($notifiable->user_email)) {
            return $notifiable->user_email;
        }

        if (isset($notifiable->contact_email)) {
            return $notifiable->contact_email;
        }

        // Se não encontrar, retorna o ID
        return 'user_' . ($notifiable->id_user ?? $notifiable->id);
    }

    protected function getSubject($notification, $notifiable)
    {
        try {
            // Se a notificação tem método toMail, tenta extrair o subject
            if (method_exists($notification, 'toMail')) {
                $mailMessage = $notification->toMail($notifiable);

                if ($mailMessage && isset($mailMessage->subject)) {
                    return $mailMessage->subject;
                }

                // Para MailMessage do Laravel
                if ($mailMessage instanceof \Illuminate\Notifications\Messages\MailMessage) {
                    return $mailMessage->subject ?? 'No Subject';
                }
            }

            // Se a notificação tem propriedade subject
            if (isset($notification->subject)) {
                return $notification->subject;
            }

            // Tentar extrair do data se existir
            if (isset($notification->data['subject'])) {
                return $notification->data['subject'];
            }
        } catch (\Exception $e) {
        }

        return 'No Subject - ' . get_class($notification);
    }

    protected function getMessageContent($notification, $notifiable)
    {
        try {
            // Para a sua notificação AuthorizationNotification específica
            /*if (get_class($notification) === 'App\Notifications\AuthorizationNotification') {
                return $this->extractAuthorizationMessage($notification, $notifiable);
            }*/

            // Método genérico para outras notificações
            if (method_exists($notification, 'toMail')) {
                $mailMessage = $notification->toMail($notifiable);

                if ($mailMessage) {
                    // Para MailMessage do Laravel
                    /* if ($mailMessage instanceof \Illuminate\Notifications\Messages\MailMessage) {
                        return $this->extractFromMailMessage($mailMessage);
                    }*/

                    // Se for uma string simples
                    if (is_string($mailMessage)) {
                        return $mailMessage;
                    }

                    // Se tiver método render ou toHtml
                    if (method_exists($mailMessage, 'render')) {
                        return $mailMessage->render();
                    }

                    if (method_exists($mailMessage, 'toHtml')) {
                        return $mailMessage->toHtml();
                    }
                }
            }

            // Tentar extrair do data
            if (isset($notification->data['html']) || isset($notification->data['message'])) {
                return $notification->data['html'] ?? $notification->data['message'] ?? null;
            }

            // Se a notificação tem propriedade html ou message
            if (isset($notification->html)) {
                return $notification->html;
            }

            if (isset($notification->message)) {
                return $notification->message;
            }
        } catch (\Exception $e) {
        }

        return null;
    }
}
