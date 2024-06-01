<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmail extends Notification
{
    use Queueable;

    protected $verificationUrl;
    protected $guestId;

    public function __construct($verificationUrl, $guestId)
    {
        $this->verificationUrl = $verificationUrl;
        $this->guestId = $guestId;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = config('app.url');
        $trackingUrl =  $url. route('email.track', ['id' => $this->guestId], false);
        $pixel = $url .'/images/pixel.png';
        return (new MailMessage)
            ->subject('Verifica tu dirección de correo electrónico')
            //->action('Verificar correo', url('/gracias?redirect=' . urlencode($this->verificationUrl)));
            ->view('emails.verify-email', [
                'url' => $this->verificationUrl,
                'trackingUrl' => $trackingUrl,
                'pixel' => $pixel,
            ]);
    }
}
