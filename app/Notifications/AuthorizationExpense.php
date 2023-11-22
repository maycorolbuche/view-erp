<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class AuthorizationExpense extends Notification
{
    use Queueable;
    public $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
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
        $html .= "<b>" . $this->data->user->name . "</b> está solicitando autorização para despesas, conforme detalhes abaixo:";
        $html .= "<p><b>Período: </b>" . Carbon::parse($this->data->start_datetime)->format('d/m/Y') . " a " . Carbon::parse($this->data->end_datetime)->format('d/m/Y');
        $html .= "<p><b>Detalhes: </b>" . $this->data->description;
        $html .= "<p><b>Clientes: </b>";
        $html .= "<ul>";
        foreach ($this->data->clients as $client) {
            $html .= "<li>" . $client->name . "</li>";
        }
        $html .= "</ul>";
        $html .= "<p><b>Autorizações Necessárias: </b>" . ($this->data->authorization_type->approval == "all"
            ? "Requer autorização de <u>todas</u> as pessoas da lista abaixo"
            : "Requer autorização de apenas <u>uma</u> pessoa da lista abaixo"
        );
        $html .= "<table>";
        $html .= "<th>Nome</th>";
        $html .= "<th>E-mail</th>";
        foreach ($this->data->statuses as $user) {
            $html .= "<tr>";
            $html .= "<td>" . $user->name . "</td>";
            $html .= "<td><a href='mailto:" . $user->email . "'>" . $user->email . "</a></td>";
            $html .= "</tr>";
        }
        $html .= "</table>";


        return (new MailMessage)
            ->subject('Solicitação de Despesas - ' . $this->data->user->name)
            ->greeting('Olá, ' . $userName . '!')
            ->line($html)
            ->action('ACESSAR SOLICITAÇÃO', route('me-authorizations.show', ['id' => $this->data->id_authorization]))
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
