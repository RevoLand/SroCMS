<?php

namespace App\Notifications;

use App\Ticket;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketAssigned extends Notification
{
    use Queueable;
    protected Ticket $ticket;
    protected User $assigner;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket, User $assigner)
    {
        $this->ticket = $ticket;
        $this->assigner = $assigner;
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
        $url = route('admin.tickets.show', $this->ticket->id);

        return (new MailMessage())
            ->subject("A Ticket (#{$this->ticket->id}) has been assigned to you!")
            ->line("A Ticket has been assigned to you by {$this->assigner->getName()}, please use the button below to view the assigned ticket.")
            ->action('View Ticket', $url)
            ->line('Thank you for playing Hydra!');
    }
}
