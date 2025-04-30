<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Console\Command;
use App\Notifications\MaintenanceAlert;

class CheckMaintenanceAlerts extends Command
{
    protected $signature = 'check:maintenance-alerts';
    protected $description = 'Vérifie et envoie les alertes de maintenance';

    public function handle()
    {
        $vehicles = Vehicle::where('prochaine_maintenance', '<=', now()->addDays(2))
            ->where('prochaine_maintenance', '>=', now())
            ->get();

        foreach ($vehicles as $vehicle) {
            $daysLeft = now()->diffInDays($vehicle->prochaine_maintenance);
            
            // Notifier les admins
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                if ($admin->email_notifications) {
                    $admin->notify(new MaintenanceAlert($vehicle, $daysLeft));
                }
            }

            // Notifier les moniteurs
            $moniteurs = User::where('role', 'moniteur')->get();
            foreach ($moniteurs as $moniteur) {
                if ($moniteur->email_notifications) {
                    $moniteur->notify(new MaintenanceAlert($vehicle, $daysLeft));
                }
            }
        }

        $this->info(count($vehicles) . ' véhicules nécessitant une maintenance ont été traités.');
    }
}