<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChange extends Notification
{
    use Queueable;
    protected string $newpassword;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $newPassword)
    {
        $this->newpassword = $newPassword;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->line('Your password has been changed by an admin.')
            ->line('Your new password is: ' . $this->newpassword)
            ->action('Login', route('users.login_form'))
            ->line('Thank you for playing Hydra!');
    }
}
