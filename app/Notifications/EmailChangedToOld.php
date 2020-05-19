<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailChangedToOld extends Notification
{
    use Queueable;
    protected string $newEmail;
    protected string $username;

    /**
     * Create a new notification instance.
     *
     * @param mixed $newEmail
     */
    public function __construct(string $newEmail, string $username)
    {
        $this->newEmail = $newEmail;
        $this->username = $username;
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
            ->line("Your E-mail address for account ' {$this->username} ' has been updated as: ' {$this->newEmail} '")
            ->action('Login', route('users.login_form'))
            ->line('Thank you for playing Hydra!');
    }
}
