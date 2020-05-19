<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailChangedToNew extends Notification
{
    use Queueable;
    protected string $oldEmail;
    protected string $username;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $oldEmail, string $username)
    {
        $this->oldEmail = $oldEmail;
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
            ->line("E-mail address for account ' {$this->username} ' has been updated with your E-mail. Old E-mail address: ' {$this->oldEmail} '")
            ->action('Login', route('users.login_form'))
            ->line('Thank you for playing Hydra!');
    }
}
