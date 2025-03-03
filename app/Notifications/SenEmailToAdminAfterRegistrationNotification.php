<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SenEmailToAdminAfterRegistrationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $code;
    public $email;
    public function __construct($SendToCode , $SendToEmail)
    {
        $this->code = $SendToCode;
        $this->email= $SendToEmail;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Creation de compte administrateur')
                    ->line('Bonjour. '.$notifiable->name .  ';')
                    ->line('Votre compte a ete creer avec succes sur la plateforme de gestion des salaires.')
                    ->line('cliquez sur le bouton ci dessous pour valider votre compte.')
                    ->line('saisisser le code ' .$this->code . 'dans le formulaire qui apparaitra')
                    ->action('Notification Action', url('/validate-account' . '/'. $this->email))
                    ->line('Merci d\'utiliser nos service!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
