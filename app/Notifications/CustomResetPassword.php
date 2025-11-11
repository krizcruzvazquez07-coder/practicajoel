<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends ResetPassword
{
    public function toMail($notifiable)
    {
        // Generar la URL correcta del enlace de restablecimiento
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        // Personalizar el correo
        return (new MailMessage)
            ->subject('restablece tu contrasenia - Patitas Perdidas Ocosingo')
            ->greeting('hola ' . $notifiable->name . '')
            ->line('recibimos una solicitud para restablecer tu contrasenia en **Patitas Perdidas Ocosingo**.')
            ->action('restablecer contraseña', $url)
            ->line('este enlace expirara en 60 minutos.')
            ->line('si no solicitaste un cambio de contraseña, puedes ignorar este correo.')
            ->salutation('el equipo de Patitas Perdidas Ocosingo');
    }
}
//**<?php

//namespace App\Notifications;

//use Illuminate\Bus\Queueable;
//use Illuminate\Contracts\Queue\ShouldQueue;
//use Illuminate\Notifications\Messages\MailMessage;
//use Illuminate\Notifications\Notification;

//class CustomResetPassword extends Notification
//{
    //use Queueable;

    /**
     * Create a new notification instance.
     */
    ////public function __construct()
    ////{
        //
    ////}

    /**
     * Get the notification's delivery channels.
     *
     * //////@return array<int, string>
     */
    //////public function via(object $notifiable): array
    //////{
        //////return ['mail'];
    //////}

    /**
     * Get the mail representation of the notification.
     */
    //////public function toMail(object $notifiable): MailMessage
    //////{
        //////return (new MailMessage)
            //////->line('The introduction to the notification.')
            //////->action('Notification Action', url('/'))
            //////->line('Thank you for using our application!');
    //////}

    /**
     * Get the array representation of the notification.
     *
     * //////@return array<string, mixed>
     */
    //////public function toArray(object $notifiable): array
    //////{
        //////return [
            //
        //////];
    //////}
//////}
