<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamFactory extends Factory
{
    protected $model = Exam::class;

    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(['theorique', 'pratique']),
            'date_exam' => $this->faker->dateTimeBetween('now', '+1 year'),
            'lieu' => $this->faker->city,
            'places_max' => $this->faker->numberBetween(5, 20),
            'statut' => $this->faker->randomElement(['planifie', 'en_cours', 'termine', 'annule']),
            'admin_id' => $this->getRandomUserIdByRole('admin'),
            'moniteur_id' => $this->getRandomUserIdByRole('moniteur'),
            'instructions' => $this->faker->optional()->paragraph,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Exam $exam) {
            $exam->candidats()->attach(
                $this->getRandomCandidatIds($exam->places_max)
            );
        });
    }

    private function getRandomUserIdByRole(string $role): ?int
    {
        return User::role($role)->inRandomOrder()->value('id');
    }

    private function getRandomCandidatIds(int $limit): array
    {
        return User::role('candidat')->inRandomOrder()->limit($limit)->pluck('id')->toArray();
    }
}