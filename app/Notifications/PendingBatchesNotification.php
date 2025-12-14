<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Batch;

class PendingBatchesNotification extends Notification
{
    use Queueable;
    public $data, $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $userName = $notifiable->name;

        $html = "";

        $batches_review_pending = Batch::with('user')->reviewPending()->whereNull('revised_by')->get();
        $count = count($batches_review_pending);

        if ($batches_review_pending) {
            if ($count > 1) {
                $html .= "<b>Os $count lotes abaixo estão pendentes de revisão:</b><br>";
            } else {
                $html .= "<b>O lote abaixo está pendente de revisão:</b><br>";
            }
            $html .= "<ul>";
            foreach ($batches_review_pending as $indx => $batch) {
                $html .= "<li>" . $batch->id_batch . " | " . $batch->user->name . " - <b>" . number_format($batch->amount, 2, ',', '.') . "</b></li>";
            }
            $html .= "</ul>";
            $html .= "<br><br>";
        }

        $batches_payment_pending = Batch::with('user')->paymentPending()->get();
        $count = count($batches_payment_pending);

        if ($batches_payment_pending) {
            if ($count > 1) {
                $html .= "<b>Os $count lotes abaixo estão pendentes de pagamento:</b><br>";
            } else {
                $html .= "<b>O lote abaixo está pendentes de pagamento:</b><br>";
            }
            $html .= "<ul>";
            foreach ($batches_review_pending as $indx => $batch) {
                $html .= "<li>" . $batch->id_batch . " | " . $batch->user->name . " - <b>" . number_format($batch->amount, 2, ',', '.') . "</b></li>";
            }
            $html .= "</ul>";
            $html .= "<br><br>";
        }

        return (new MailMessage)
            ->subject('Lotes pendentes')
            ->greeting('Olá, ' . $userName . '!')
            ->line($html)
            ->markdown('vendor.notifications.email');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
