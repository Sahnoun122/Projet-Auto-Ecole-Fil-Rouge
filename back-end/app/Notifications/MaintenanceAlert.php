<?php

namespace App\Notifications;

use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MaintenanceAlert extends Notification implements ShouldQueue
{
    use Queueable;

    public $vehicle;
    public $daysLeft;

    public function __construct(Vehicle $vehicle, $daysLeft)
    {
        $this->vehicle = $vehicle;
        $this->daysLeft = $daysLeft;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Alerte Maintenance Véhicule')
            ->greeting('Bonjour ' . $notifiable->prenom . ',')
            ->line('Une maintenance est prévue bientôt pour le véhicule suivant :')
            ->line('Véhicule: ' . $this->vehicle->marque . ' ' . $this->vehicle->modele)
            ->line('Immatriculation: ' . $this->vehicle->immatriculation)
            ->line('Date prévue: ' . $this->vehicle->prochaine_maintenance->format('d/m/Y'))
            ->line('Jours restants: ' . $this->daysLeft)
            ->action('Voir les détails', route('admin.vehicles'))
            ->line('Merci de prendre les dispositions nécessaires.');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Maintenance prévue pour ' . $this->vehicle->immatriculation . ' dans ' . $this->daysLeft . ' jours',
            'url' => route('admin.vehicles'),
            'icon' => 'car',
            'vehicle_id' => $this->vehicle->id
        ];
    }
}