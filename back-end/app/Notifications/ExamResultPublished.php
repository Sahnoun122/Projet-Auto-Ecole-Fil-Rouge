<?php

namespace App\Notifications;

use App\Models\Exam;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ExamResultPublished extends Notification implements ShouldQueue
{
    use Queueable;

    public $exam;

    public function __construct(Exam $exam)
    {
        $this->exam = $exam;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $result = $this->exam->participants()->where('user_id', $notifiable->id)->first()->pivot;

        return (new MailMessage)
            ->subject('Résultats de votre examen')
            ->greeting('Bonjour ' . $notifiable->prenom . ',')
            ->line('Les résultats de votre examen sont disponibles:')
            ->line('Type: ' . ucfirst($this->exam->type))
            ->line('Date: ' . $this->exam->date_exam->format('d/m/Y'))
            ->line('Résultat: ' . ucfirst(str_replace('_', ' ', $result->resultat)))
            ->line('Score: ' . $result->score . '/100')
            ->action('Voir les détails', url('/my-exams/' . $this->exam->id . '/results'))
            ->line('Merci de votre confiance!');
    }

    public function toArray($notifiable)
    {
        $result = $this->exam->participants()->where('user_id', $notifiable->id)->first()->pivot;

        return [
            'message' => 'Résultats disponibles pour votre examen du ' . $this->exam->date_exam->format('d/m/Y'),
            'url' => '/my-exams/' . $this->exam->id . '/results',
            'icon' => 'clipboard-check',
            'exam_id' => $this->exam->id
        ];
    }
}