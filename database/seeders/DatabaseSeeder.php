<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    $this->call([
        BranchSeeder::class,   // 1. Sucursales
        UsuarioSeeder::class,  // 2. Tus nuevos usuarios (Admin/Vendedor)
        ProductSeeder::class,  // 3. Los productos (GPU, CPU, etc.)
        StockSeeder::class,    // 4. Cantidades en cada tienda
        VentaSeeder::class,
    ]);
}
} 