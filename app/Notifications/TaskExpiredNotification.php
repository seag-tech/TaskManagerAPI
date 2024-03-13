<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class TaskExpiredNotification extends Notification
{
    use Queueable;



    public function __construct()
    {
    }


    public function via(object $notifiable): array
    {

        return ['mail'];
    }


    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('¡Tarea vencida!')
            ->line('La fecha de la tarea ha finalizado.')
            ->line('Por favor, revisa tus tareas pendientes.')
            ->line('Gracias por usar nuestra aplicación.');
    }


    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
