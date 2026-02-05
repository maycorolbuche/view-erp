<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BatchNotification extends Notification
{
    use Queueable;
    public $data, $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data, $type = "new")
    {
        $this->data = $data;
        $this->type = $type;
    }

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

        if ($this->type == 'new') {

            $html .= "<b>" . $this->data->user->name . "</b> gerou o lote nº <b>" . $this->data->id_batch . "</b>:";

            $html .= "<p>Detalhes do lote:";
            $html .= "<hr style='border:0;border-top:1px solid #AAA'>";

            $html .= "<p><b>Quantidade de Despesas: </b>" . $this->data->expenses_count;
            $html .= "<br><b>Valor do Lote: </b> R$ " . number_format($this->data->amount, 2, ',', '.');
            $html .= "<br><b>(-) Vl. não Reembolsável: </b> R$ " . number_format($this->data->non_refundable_amount, 2, ',', '.');
            $html .= "<br><b>(-) Vl. Desconto: </b> R$ " . number_format($this->data->discount, 2, ',', '.');
            $html .= "<br><b>(=) Valor do Reembolso: </b> R$ " . number_format($this->data->refund_amount, 2, ',', '.');

            return (new MailMessage)
                ->subject('Novo Lote Gerado | ' . $this->data->id_batch)
                ->greeting('Olá, ' . $userName . '!')
                ->line($html)
                ->action('ACESSAR DOCUMENTO', route('pdf.batch', ['id' => Crypt::encrypt($this->data->id_batch)]))
                ->markdown('vendor.notifications.email');
        } elseif ($this->type == 'delete') {

            $html .= "<b>" . Auth::user()->name . "</b> desfez o lote nº <b>" . $this->data . "</b>:";

            return (new MailMessage)
                ->subject('Lote Desfeito | ' . $this->data)
                ->greeting('Olá, ' . $userName . '!')
                ->line($html)
                ->markdown('vendor.notifications.email');
        } elseif ($this->type == 'user') {

            $subject = "";
            if ($this->data->status["type"] == "reviewed") {
                $subject = "Lote Aprovado | " . $this->data->id_batch;

                $html .= "O lote nº <b>" . $this->data->id_batch . "</b> foi aprovado. ";
                if ($this->data->estimated_payment_date && $this->data->refundable_amount > 0) {
                    $html .= "A data de pagamento está prevista para ocorrer em " . Carbon::parse($this->data->estimated_payment_date)->format('d/m/Y');
                }
            } elseif ($this->data->status["type"] == "rejected") {
                $subject = "Lote Reprovado | " . $this->data->id_batch;

                $html .= "O lote nº <b>" . $this->data->id_batch . "</b> foi reprovado por <b>" . Auth::user()->name . "</b>.";
                $html .= "<p><b>Motivo da rejeição:</b><br>" . nl2br($this->data->notes);
            } elseif ($this->data->status["type"] == "closed") {
                if ($this->data->refundable_amount > 0) {
                    $subject = "Lote Pago | " . $this->data->id_batch;
                    $html .= "O lote nº <b>" . $this->data->id_batch . "</b> foi reembolsado.";
                } else {
                    $subject = "Lote Fechado | " . $this->data->id_batch;
                    $html .= "O lote nº <b>" . $this->data->id_batch . "</b> foi fechado.";
                }
            }

            return (new MailMessage)
                ->subject($subject)
                ->greeting('Olá, ' . $userName . '!')
                ->line($html)
                ->markdown('vendor.notifications.email');
        }
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
