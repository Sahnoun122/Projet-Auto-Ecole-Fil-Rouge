<?php

namespace App\Notifications;

use App\Models\Exam;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ExamScheduled extends Notification implements ShouldQueue
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
        return (new MailMessage)
            ->subject('Nouvel examen programmé')
            ->greeting('Bonjour ' . $notifiable->prenom . ',')
            ->line('Un nouvel examen a été programmé pour vous:')
            ->line('Type: ' . ucfirst($this->exam->type))
            ->line('Date: ' . $this->exam->date_exam->format('d/m/Y H:i'))
            ->line('Lieu: ' . $this->exam->lieu)
            ->action('Voir les détails', url('/my-exams'))
            ->line('Merci de votre confiance!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Un nouvel examen a été programmé pour le ' . $this->exam->date_exam->format('d/m/Y'),
            'url' => '/my-exams',
            'icon' => 'calendar-alt',
            'exam_id' => $this->exam->id
        ];
    }
}