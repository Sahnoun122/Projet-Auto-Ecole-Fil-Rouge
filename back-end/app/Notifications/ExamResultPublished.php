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
            ->subject('Résultat de votre examen')
            ->line('Les résultats de votre examen sont disponibles.')
            ->line('Résultat: ' . ucfirst(str_replace('_', ' ', $result->resultat)))
            ->line('Score: ' . $result->score . '/100')
            ->line('Commentaires: ' . $result->feedbacks)
            ->action('Voir les détails', url('/exams/' . $this->exam->id))
            ->line('Merci de votre confiance!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Les résultats de votre examen du ' . $this->exam->date_exam->format('d/m/Y') . ' sont disponibles',
            'url' => '/exams/' . $this->exam->id,
            'exam_id' => $this->exam->id
        ];
    }
}