<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailMarkdown extends Notification
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

        $trackingUrl = config('app.url') . route('email.track', ['id' => $this->guestId], false);

        return (new MailMessage)
            ->subject('Verifica tu dirección de correo electrónico')
            ->markdown('emails.verify-email-markdown', [
                'url' => $this->verificationUrl,
                'trackingUrl' => $trackingUrl,
            ]);
    }
}
