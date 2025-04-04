<?php

namespace Database\Factories;

use App\Models\CoursConduite;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CoursConduiteFactory extends Factory
{
    protected $model = CoursConduite::class;

    public function definition()
    {
        return [
            'date_heure' => $this->faker->dateTime,
            'duree_minutes' => $this->faker->numberBetween(30, 240),
            'moniteur_id' => \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'moniteur'))->first()->id,
            'vehicule_id' => \App\Models\Vehicle::where('statut', 'disponible')->first()->id,
            'statut' => 'planifie',
            'admin_id' => 1, 
        ];
    }
}
