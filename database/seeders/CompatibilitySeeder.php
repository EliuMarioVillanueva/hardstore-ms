<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Compatibility;
use App\Models\Product;

class CompatibilitySeeder extends Seeder
{
    public function run(): void
    {
        // ============================================
        // 1. CPUs AM4 (socket AM4, RAM DDR4)
        // ============================================
        $cpusAm4 = Product::where('tipo', 'CPU')
            ->where(function($q) {
                $q->where('name', 'LIKE', '%Ryzen 5%')
                  ->orWhere('name', 'LIKE', '%Ryzen 7%')
                  ->orWhere('name', 'LIKE', '%Ryzen 9%');
            })
            ->get();

        foreach ($cpusAm4 as $cpu) {
            Compatibility::updateOrCreate(
                ['producto_id' => $cpu->id],
                ['tipo_socket' => 'AM4', 'tipo_ram' => 'DDR4']
            );
        }

        // ============================================
        // 2. CPUs AM5 (socket AM5, RAM DDR5)
        // ============================================
        $cpusAm5 = Product::where('tipo', 'CPU')
            ->where(function($q) {
                $q->where('name', 'LIKE', '%Ryzen 7 7600X%')
                  ->orWhere('name', 'LIKE', '%Ryzen 9 7900X%');
            })
            ->get();

        foreach ($cpusAm5 as $cpu) {
            Compatibility::updateOrCreate(
                ['producto_id' => $cpu->id],
                ['tipo_socket' => 'AM5', 'tipo_ram' => 'DDR5']
            );
        }

        // ============================================
        // 3. CPUs Intel LGA1700
        // ============================================
        $cpusIntel = Product::where('tipo', 'CPU')
            ->where(function($q) {
                $q->where('name', 'LIKE', '%Intel Core i5%')
                  ->orWhere('name', 'LIKE', '%Intel Core i7%')
                  ->orWhere('name', 'LIKE', '%Intel Core i9%');
            })
            ->get();

        foreach ($cpusIntel as $cpu) {
            Compatibility::updateOrCreate(
                ['producto_id' => $cpu->id],
                ['tipo_socket' => 'LGA1700', 'tipo_ram' => 'Dual']
            );
        }

        // ============================================
        // 4. PLACAS AM4
        // ============================================
        $placasAm4 = Product::where('tipo', 'Placa')
            ->where(function($q) {
                $q->where('name', 'LIKE', '%B550%')
                  ->orWhere('name', 'LIKE', '%X570%');
            })
            ->get();

        foreach ($placasAm4 as $placa) {
            Compatibility::updateOrCreate(
                ['producto_id' => $placa->id],
                ['tipo_socket' => 'AM4', 'tipo_ram' => 'DDR4']
            );
        }

        // ============================================
        // 5. PLACAS AM5
        // ============================================
        $placasAm5 = Product::where('tipo', 'Placa')
            ->where(function($q) {
                $q->where('name', 'LIKE', '%B650%')
                  ->orWhere('name', 'LIKE', '%X670E%');
            })
            ->get();

        foreach ($placasAm5 as $placa) {
            Compatibility::updateOrCreate(
                ['producto_id' => $placa->id],
                ['tipo_socket' => 'AM5', 'tipo_ram' => 'DDR5']
            );
        }

        // ============================================
        // 6. PLACAS Intel LGA1700
        // ============================================
        $placasIntel = Product::where('tipo', 'Placa')
            ->where(function($q) {
                $q->where('name', 'LIKE', '%Z790%')
                  ->orWhere('name', 'LIKE', '%H610%')
                  ->orWhere('name', 'LIKE', '%B560%');
            })
            ->get();

        foreach ($placasIntel as $placa) {
            Compatibility::updateOrCreate(
                ['producto_id' => $placa->id],
                ['tipo_socket' => 'LGA1700', 'tipo_ram' => 'Dual']
            );
        }

        // ============================================
        // 7. RAM DDR4
        // ============================================
        $ramsDdr4 = Product::where('tipo', 'RAM')
            ->where(function($q) {
                $q->where('name', 'LIKE', '%DDR4%')
                  ->orWhere('sku', 'LIKE', '%D4%');
            })
            ->get();

        foreach ($ramsDdr4 as $ram) {
            Compatibility::updateOrCreate(
                ['producto_id' => $ram->id],
                ['tipo_ram' => 'DDR4']
            );
        }

        // ============================================
        // 8. RAM DDR5
        // ============================================
        $ramsDdr5 = Product::where('tipo', 'RAM')
            ->where(function($q) {
                $q->where('name', 'LIKE', '%DDR5%')
                  ->orWhere('sku', 'LIKE', '%D5%');
            })
            ->get();

        foreach ($ramsDdr5 as $ram) {
            Compatibility::updateOrCreate(
                ['producto_id' => $ram->id],
                ['tipo_ram' => 'DDR5']
            );
        }

        $this->command->info('✅ Compatibilidades creadas exitosamente.');
    }
}