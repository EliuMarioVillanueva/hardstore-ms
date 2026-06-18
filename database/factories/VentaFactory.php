<?php

namespace Database\Factories;

use App\Models\Venta;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

class VentaFactory extends Factory
{
    protected $model = Venta::class;

    public function definition(): array
    {
        $vendedor = User::where('rol', 'vendedor')->inRandomOrder()->first();
        
        if (!$vendedor) {
            $vendedor = User::factory()->vendedor()->create();
        }

        $sucursal = Branch::inRandomOrder()->first();
        if (!$sucursal) {
            $sucursal = Branch::factory()->create();
        }

        return [
            'usuario_id' => $vendedor->id,
            'sucursal_id' => $sucursal->id,
            'total' => 0,
            'fecha' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}