<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ComboController extends Controller
{
    public function index()
    {
        // ============================================
        // COMBOS DE DEMOSTRACIÓN (SIEMPRE VISIBLES)
        // ============================================
        $combos = [];

        // Buscar productos reales
        $cpus = Product::where('tipo', 'CPU')->get();
        $placas = Product::where('tipo', 'Placa')->get();
        $rams = Product::where('tipo', 'RAM')->get();

        // Si hay productos reales, usarlos
        if ($cpus->count() > 0 && $placas->count() > 0 && $rams->count() > 0) {
            $maxCombos = min(6, $cpus->count());
            for ($i = 0; $i < $maxCombos; $i++) {
                $combos[] = [
                    'cpu' => $cpus[$i],
                    'placa' => $placas->random(),
                    'ram' => $rams->random(),
                    'stock' => true,
                ];
            }
        }

        // Si NO hay productos reales, usar combos de demostración
        if (count($combos) === 0) {
            $combos = [
                [
                    'cpu' => (object) ['name' => 'AMD Ryzen 7 5800X', 'precio_venta' => 280, 'id' => 1],
                    'placa' => (object) ['name' => 'ASUS ROG Strix B550-F', 'precio_venta' => 185, 'id' => 2],
                    'ram' => (object) ['name' => 'Corsair Vengeance 16GB DDR4', 'precio_venta' => 55, 'id' => 3],
                    'stock' => true,
                ],
                [
                    'cpu' => (object) ['name' => 'Intel Core i7-13700K', 'precio_venta' => 390, 'id' => 4],
                    'placa' => (object) ['name' => 'MSI PRO Z790-P DDR4', 'precio_venta' => 220, 'id' => 5],
                    'ram' => (object) ['name' => 'G.Skill Trident Z 32GB DDR4', 'precio_venta' => 115, 'id' => 6],
                    'stock' => true,
                ],
                [
                    'cpu' => (object) ['name' => 'AMD Ryzen 9 7900X', 'precio_venta' => 420, 'id' => 7],
                    'placa' => (object) ['name' => 'ASUS Prime X670E-Pro', 'precio_venta' => 340, 'id' => 8],
                    'ram' => (object) ['name' => 'Crucial RAM 32GB DDR5', 'precio_venta' => 130, 'id' => 9],
                    'stock' => true,
                ],
            ];
        }

        return view('welcome', compact('combos'));
    }
}