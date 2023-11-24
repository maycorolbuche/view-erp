<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class AuthorizationNotification extends Notification
{
    use Queueable;
    public $data;

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

        $self = false;
        if ($this->data->user->id_user == $notifiable->id_user) {
            $self = true;
        }

        $html = "";
        if ($this->type == 'status') {
            if ($self) {
                $html .= "O status da sua solicitação foi atualizado! Seguem os detalhes:";
            } else {
                $html .= "O status da solicitação de <b>" . $this->data->user->name . "</b> foi atualizado. Seguem os detalhes:";
            }
        } else {
            if ($self) {
                $html .= "Seguem os detalhes da sua solicitação:";
            } else {
                $html .= "<b>" . $this->data->user->name . "</b> está solicitando autorização para a solicitação abaixo:";
            }
        }

        $html .= "<hr style='border:0;border-top:1px solid #AAA'>";
        $html .= "<p><b>Tipo de Solicitação: </b>" . $this->data->authorization_type->name;

        $color = '';
        $status = 'Expirado';
        $status_subject = '';
        if ($this->data->approved === 1) {
            $color = 'green';
            $status = 'Aprovado';
            $status_subject = ' | APROVADO';
        } elseif ($this->data->approved === 0) {
            $color = 'red';
            $status = 'Negado';
            $status_subject = ' | NEGADO';
        } elseif ($this->data->active === 1) {
            $color = 'orange';
            $status = 'Pendente';
            $status_subject = ' | PENDENTE';
        }
        $html .= "<p><b>Status: </b> <span style='font-weight:bold;color:$color'>$status</span>";

        if ($this->data->authorization_type->type == 'expense') {
            $html .= "<p><b>Período: </b>" . Carbon::parse($this->data->start_datetime)->format('d/m/Y') . " a " . Carbon::parse($this->data->end_datetime)->format('d/m/Y');
        }

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
        $html .= "<table class='table' style='width:100%;'>";
        $html .= "<th>Nome</th>";
        $html .= "<th>E-mail</th>";
        $html .= "<th>Status</th>";
        $html .= "<th></th>";
        foreach ($this->data->statuses as $user) {
            $user_color = '';
            $user_status = 'Não informado';
            if ($user->pivot->approved === 1) {
                $user_color = 'green';
                $user_status = 'Aprovado';
            } elseif ($user->pivot->approved === 0) {
                $user_color = 'red';
                $user_status = 'Negado';
            } elseif ($this->data->approved === null && $this->data->active === 1) {
                $user_color = 'orange';
                $user_status = 'Pendente';
            }

            $html .= "<tr>";
            $html .= "<td>" . $user->name . "</td>";
            $html .= "<td><a href='mailto:" . $user->email . "'>" . $user->email . "</a></td>";
            $html .= "<td style='text-align:center;font-weight:bold;color:" . $user_color . "'>" . $user_status . "</td>";
            $html .= "<td>" . $user->pivot->description . "</td>";
            $html .= "</tr>";
        }
        $html .= "</table>";


        return (new MailMessage)
            ->subject('Solicitação de ' . $this->data->authorization_type->name  . (!$self ? ' - ' . $this->data->user->name : '') . $status_subject)
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
