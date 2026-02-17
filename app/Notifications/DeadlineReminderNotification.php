<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Assignment;

class DeadlineReminderNotification extends Notification
{
    use Queueable;

    protected $assignment;
    protected $daysLeft;

    /**
     * Create a new notification instance.
     */
    public function __construct(Assignment $assignment, int $daysLeft)
    {
        $this->assignment = $assignment;
        $this->daysLeft = $daysLeft;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $urgencyLevel = $this->daysLeft <= 1 ? 'urgent' : 'important';
        
        return (new MailMessage)
            ->subject("Rappel: {$this->assignment->title} - {$this->daysLeft} jour(s) restant(s)")
            ->greeting("Bonjour {$notifiable->name}!")
            ->line("Rappel {$urgencyLevel}: votre devoir approche.")
            ->line("**Devoir:** {$this->assignment->title}")
            ->line("**Matière:** {$this->assignment->subject}")
            ->line("**Échéance:** {$this->assignment->deadline->format('d/m/Y')}")
            ->line("**Temps restant:** {$this->daysLeft} jour(s)")
            ->action('Voir mes devoirs', url('/assignments'))
            ->line('Bon courage dans vos révisions!');
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
