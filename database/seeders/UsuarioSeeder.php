<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Branch; // Importante para buscar una sucursal real
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
{
    User::create([
        'name' => 'Admin HardStore',
        'email' => 'admin@hardstore.com',
        'password' => Hash::make('admin123'),
        'rol' => 'admin',
        'sucursal_id' => null, 
    ]);

    User::create([
        'name' => 'Vendedor Central',
        'email' => 'vendedor@hardstore.com',
        'password' => Hash::make('vendedor123'),
        'rol' => 'vendedor',
        'sucursal_id' => 1, 
    ]);
}
}