<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NouveauCoursNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $cours;

    public function __construct($cours)
    {
        $this->cours = $cours;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouveau cours de conduite planifié')
            ->line('Un nouveau cours de conduite a été planifié pour vous.')
            ->line('Date : ' . $this->cours->date_heure->format('d/m/Y H:i'))
            ->line('Durée : ' . $this->cours->duree_minutes . ' minutes')
            ->action('Voir les détails', url('/cours/' . $this->cours->id))
            ->line('Merci d\'utiliser notre application !');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Nouveau cours planifié le ' . $this->cours->date_heure->format('d/m/Y H:i'),
            'cours_id' => $this->cours->id,
            'url' => '/cours/' . $this->cours->id,
        ];
    }
}
