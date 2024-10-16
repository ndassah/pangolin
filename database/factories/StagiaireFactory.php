<?php

namespace Database\Factories;

use App\Models\Stagiaire;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StagiaireFactory extends Factory
{
    /**
     * Le nom du modèle correspondant.
     *
     * @var string
     */
    protected $model = Stagiaire::class;

    /**
     * Définir l'état par défaut du modèle.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid(),
            'user_id' => $this->faker->numberBetween(1),
            'service_id' => $this->faker->numberBetween(1,10),
        ];
    }
}
