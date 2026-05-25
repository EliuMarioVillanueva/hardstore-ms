<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product; 
use App\Models\Branch;
use App\Models\Stock;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        $productos = Product::all();
        $sucursales = Branch::all();

        foreach ($productos as $producto) {
            foreach ($sucursales as $sucursal) {
                Stock::create([
                    'producto_id' => $producto->id,
                    'sucursal_id' => $sucursal->id,
                    'cantidad'    => rand(10, 50),
                ]);
            }
        }
    }
}