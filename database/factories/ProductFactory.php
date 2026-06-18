<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $tipos = ['CPU', 'GPU', 'RAM', 'Placa', 'SSD', 'PSU', 'Gabinete', 'Cooler', 'Monitor', 'periferico'];
        $tipo = $this->faker->randomElement($tipos);
        
        // Generar SKU según el tipo
        $prefijo = match($tipo) {
            'CPU' => 'CPU',
            'GPU' => 'GPU',
            'RAM' => 'RAM',
            'Placa' => 'MB',
            'SSD' => 'SSD',
            'PSU' => 'PSU',
            'Gabinete' => 'CASE',
            'Cooler' => 'COOL',
            'Monitor' => 'MON',
            default => 'PER',
        };
        
        return [
            'sku' => $this->faker->unique()->regexify($prefijo . '-[A-Z]{2}-[0-9]{4}'),
            'name' => $this->faker->words(3, true),
            'tipo' => $tipo,
            'precio_venta' => $this->faker->randomFloat(2, 10, 500),
        ];
    }
}