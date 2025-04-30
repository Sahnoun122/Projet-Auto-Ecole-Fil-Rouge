<?php

namespace App\Notifications;

use App\Models\CoursConduite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // Make sure this is present

class NouveauCoursConduiteCandidat extends Notification implements ShouldQueue
{
    use Queueable;

    public $cours;

public $isUpdate;

public function __construct(CoursConduite $cours, bool $isUpdate = false)
{
    $this->cours = $cours;
    $this->isUpdate = $isUpdate;
}



    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $unsubscribeUrl = route('email.unsubscribe', [
            'user' => $notifiable->id,
            'token' => Hash::make($notifiable->id.$notifiable->email)
        ]);
    
        return (new MailMessage)
            ->subject('Nouveau cours de conduite programmé')
            ->markdown('emails.cours-conduite-candidat', [
                'cours' => $this->cours,
                'user' => $notifiable,
                'unsubscribeUrl' => $unsubscribeUrl
            ]);
    }

    public function toArray($notifiable)
    {
        $relativePath = route('candidats.conduite', ['courseId' => $this->cours->id], false); 
        $fullUrl = rtrim(env('APP_URL', 'http://127.0.0.1:8000'), '/') . '/' . ltrim($relativePath, '/');

        $configUrl = config('app.url');
        Log::info('[NouveauCoursConduiteCandidat] Config URL: ' . $configUrl . ' | Generated URL: ' . $fullUrl);

        return [
            'type' => 'nouveau_cours',
            'date_heure' => $this->cours->date_heure,
            'moniteur' => $this->cours->moniteur->nom_complet,
            'vehicule' => $this->cours->vehicule->marque,
            'message' => 'Un nouveau cours de conduite a été programmé pour vous.',
            'url' => $fullUrl
        ];
    }
}