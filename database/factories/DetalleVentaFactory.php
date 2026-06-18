<?php

namespace Database\Factories;

use App\Models\Venta;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetalleVentaFactory extends Factory
{
    public function definition(): array
    {
        $producto = Product::inRandomOrder()->first();
        
        if (!$producto) {
            $producto = Product::factory()->create();
        }

        $cantidad = $this->faker->numberBetween(1, 3);

        return [
            'venta_id' => Venta::factory(),
            'producto_id' => $producto->id,
            'cantidad' => $cantidad,
            'precio_unitario_historico' => $producto->precio_venta,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}