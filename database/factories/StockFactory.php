<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    public function definition(): array
    {
        return [
            'producto_id' => Product::factory(),
            'sucursal_id' => Branch::factory(),
            'cantidad' => $this->faker->numberBetween(5, 50),
        ];
    }
}