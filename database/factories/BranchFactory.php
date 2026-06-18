<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' - ' . $this->faker->city(),
            'es_principal' => $this->faker->boolean(20), // 20% de probabilidad de ser principal
        ];
    }
}