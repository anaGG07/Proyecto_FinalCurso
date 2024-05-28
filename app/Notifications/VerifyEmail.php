<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmail extends Notification
{
    use Queueable;

    protected $verificationUrl;

    public function __construct($verificationUrl)
    {
        $this->verificationUrl = $verificationUrl;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {

        return (new MailMessage)
            ->subject('Verifica tu dirección de correo electrónico')
            ->line('Haz clic en el botón de abajo para verificar tu dirección de correo electrónico.')
            ->action('Verificar Correo', $this->verificationUrl)
            ->line('Si no has solicitado esta verificación, no se requiere ninguna acción adicional.');
    }
}
