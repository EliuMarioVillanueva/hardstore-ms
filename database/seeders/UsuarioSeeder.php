<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener sucursales existentes
        $sucursales = Branch::all();

        if ($sucursales->isEmpty()) {
            $this->command->error(' No hay sucursales. Ejecuta BranchSeeder primero.');
            return;
        }

        // ============================================
        // 1. ADMIN
        // ============================================
        User::create([
            'name' => 'Admin HardStore',
            'email' => 'admin@hardstore.com',
            'password' => Hash::make('admin123'),
            'rol' => 'admin',
            'sucursal_id' => null,
        ]);

        // ============================================
        // 2. VENDEDORES (4, uno por sucursal)
        // ============================================
        $vendedoresData = [
            ['name' => 'Vendedor Central', 'sucursal_id' => 1],
            ['name' => 'Vendedor Norte', 'sucursal_id' => 2],
            ['name' => 'Vendedor Sur', 'sucursal_id' => 3],
            ['name' => 'Vendedor Express', 'sucursal_id' => 4],
        ];

        foreach ($vendedoresData as $data) {
            // Verificar que la sucursal existe
            $sucursal = Branch::find($data['sucursal_id']);
            if (!$sucursal) {
                $this->command->warn("Sucursal ID {$data['sucursal_id']} no existe. Saltando...");
                continue;
            }

            User::create([
                'name' => $data['name'],
                'email' => strtolower(str_replace(' ', '', $data['name'])) . '@hardstore.com',
                'password' => Hash::make('vendedor123'),
                'rol' => 'vendedor',
                'sucursal_id' => $data['sucursal_id'],
            ]);
        }

        // ============================================
        // 3. CLIENTES (20)
        // ============================================
        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'name' => 'Cliente ' . $i,
                'email' => 'cliente' . $i . '@hardstore.com',
                'password' => Hash::make('cliente' . $i . '123'),
                'rol' => 'cliente',
                'sucursal_id' => null,
            ]);
        }

        $this->command->info(' Usuarios creados: 1 Admin, 4 Vendedores, 20 Clientes.');
    }
}