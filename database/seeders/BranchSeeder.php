<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. La sucursal principal
        Branch::create([
            'name' => 'Sede Central - Parque Industrial',
            'es_principal' => true,
        ]);

        // 2. Branch secundaria
        Branch::create([
            'name' => 'Branch Norte - Centro Comercial',
            'es_principal' => false,
        ]);

        // 3. Branch secundaria
        Branch::create([
            'name' => 'Branch Sur - Avenida Principal',
            'es_principal' => false,
        ]);

        // 4. Branch secundaria
        Branch::create([
            'name' => 'Punto de Venta Express - Terminal',
            'es_principal' => false,
        ]);
    }
}