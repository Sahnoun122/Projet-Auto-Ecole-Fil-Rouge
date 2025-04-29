<?php

namespace App\Notifications;

use App\Models\CoursConduite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NouveauCoursConduiteMoniteur extends Notification implements ShouldQueue
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
            ->subject('Nouveau cours de conduite assigné')
            ->markdown('emails.cours-conduite-moniteur', [
                'cours' => $this->cours,
                'user' => $notifiable
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'nouveau_cours',
            'date_heure' => $this->cours->date_heure,
            'candidat_principal' => $this->cours->candidat->nom_complet,
            'vehicule' => $this->cours->vehicule->marque,
            'message' => 'Un nouveau cours de conduite vous a été assigné.',
            'url' => route('moniteur.conduite')
        ];
    }
}