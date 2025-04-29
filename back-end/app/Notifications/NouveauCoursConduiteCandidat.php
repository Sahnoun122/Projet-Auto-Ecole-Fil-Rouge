<?php

namespace App\Notifications;

use App\Models\CoursConduite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NouveauCoursConduiteCandidat extends Notification implements ShouldQueue
{
    use Queueable;

    public $cours;

    public function __construct(CoursConduite $cours)
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
            ->subject('Nouveau cours de conduite programmé')
            ->markdown('emails.cours-conduite-candidat', [
                'cours' => $this->cours,
                'user' => $notifiable
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'nouveau_cours',
            'date_heure' => $this->cours->date_heure,
            'moniteur' => $this->cours->moniteur->nom_complet,
            'vehicule' => $this->cours->vehicule->marque,
            'message' => 'Un nouveau cours de conduite a été programmé pour vous.',
            'url' => route('candidat.conduite')
        ];
    }
}