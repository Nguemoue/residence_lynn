<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingNotification extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Confirmation de votre réservation')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Votre réservation a été enregistrée avec succès.')
            ->line('**Détails de la réservation :**')
            ->line('Hébergement : ' . $this->booking->accommodation->code)
            ->line('Date de début : ' . $this->booking->start_date->format('d/m/Y'))
            ->line('Date de fin : ' . $this->booking->end_date->format('d/m/Y'))
            ->line('Nombre de personnes : ' . $this->booking->guest_number)
            ->action('Voir votre réservation', route('bookings.show', $this->booking->id))
            ->line('Merci de choisir notre service !');
    }

    public function toArray($notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'message' => 'Votre réservation pour ' . $this->booking->accommodation->code . ' a été confirmée.',
            'start_date' => $this->booking->start_date->format('d/m/Y'),
            'end_date' => $this->booking->end_date->format('d/m/Y'),
        ];
    }
}
