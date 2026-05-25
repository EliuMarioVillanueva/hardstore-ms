<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Compatibility;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            // --- PROCESADORES (CPUs) ---
            ['sku' => 'CPU-AMD-5600X', 'name' => 'AMD Ryzen 5 5600X', 'tipo' => 'CPU', 'precio_venta' => 199.99, 'socket' => 'AM4', 'ram' => 'DDR4'],
            ['sku' => 'CPU-AMD-5800X', 'name' => 'AMD Ryzen 7 5800X', 'tipo' => 'CPU', 'precio_venta' => 280.00, 'socket' => 'AM4', 'ram' => 'DDR4'],
            ['sku' => 'CPU-AMD-5950X', 'name' => 'AMD Ryzen 9 5950X', 'tipo' => 'CPU', 'precio_venta' => 450.00, 'socket' => 'AM4', 'ram' => 'DDR4'],
            ['sku' => 'CPU-AMD-7600X', 'name' => 'AMD Ryzen 5 7600X', 'tipo' => 'CPU', 'precio_venta' => 240.00, 'socket' => 'AM5', 'ram' => 'DDR5'],
            ['sku' => 'CPU-AMD-7900X', 'name' => 'AMD Ryzen 9 7900X', 'tipo' => 'CPU', 'precio_venta' => 420.00, 'socket' => 'AM5', 'ram' => 'DDR5'],
            ['sku' => 'CPU-INT-12400', 'name' => 'Intel Core i5-12400', 'tipo' => 'CPU', 'precio_venta' => 170.00, 'socket' => 'LGA1700', 'ram' => 'Dual'],
            ['sku' => 'CPU-INT-13700K', 'name' => 'Intel Core i7-13700K', 'tipo' => 'CPU', 'precio_venta' => 390.00, 'socket' => 'LGA1700', 'ram' => 'Dual'],
            ['sku' => 'CPU-INT-14900K', 'name' => 'Intel Core i9-14900K', 'tipo' => 'CPU', 'precio_venta' => 580.00, 'socket' => 'LGA1700', 'ram' => 'Dual'],
            ['sku' => 'CPU-INT-11400', 'name' => 'Intel Core i5-11400', 'tipo' => 'CPU', 'precio_venta' => 140.00, 'socket' => 'LGA1200', 'ram' => 'DDR4'],
            ['sku' => 'CPU-INT-10100', 'name' => 'Intel Core i3-10100', 'tipo' => 'CPU', 'precio_venta' => 95.00, 'socket' => 'LGA1200', 'ram' => 'DDR4'],

            // --- PLACAS BASE (Motherboards) ---
            ['sku' => 'MB-ASUS-B550', 'name' => 'ASUS ROG Strix B550-F', 'tipo' => 'Placa', 'precio_venta' => 185.00, 'socket' => 'AM4', 'ram' => 'DDR4'],
            ['sku' => 'MB-MSI-X570', 'name' => 'MSI MPG X570S Carbon', 'tipo' => 'Placa', 'precio_venta' => 260.00, 'socket' => 'AM4', 'ram' => 'DDR4'],
            ['sku' => 'MB-GIG-B650', 'name' => 'Gigabyte B650 Gaming X', 'tipo' => 'Placa', 'precio_venta' => 210.00, 'socket' => 'AM5', 'ram' => 'DDR5'],
            ['sku' => 'MB-ASUS-X670E', 'name' => 'ASUS Prime X670E-Pro', 'tipo' => 'Placa', 'precio_venta' => 340.00, 'socket' => 'AM5', 'ram' => 'DDR5'],
            ['sku' => 'MB-MSI-Z790D4', 'name' => 'MSI PRO Z790-P DDR4', 'tipo' => 'Placa', 'precio_venta' => 220.00, 'socket' => 'LGA1700', 'ram' => 'DDR4'],
            ['sku' => 'MB-ASUS-Z790D5', 'name' => 'ASUS ROG Maximus Z790', 'tipo' => 'Placa', 'precio_venta' => 600.00, 'socket' => 'LGA1700', 'ram' => 'DDR5'],
            ['sku' => 'MB-GIG-H610', 'name' => 'Gigabyte H610M S2H', 'tipo' => 'Placa', 'precio_venta' => 90.00, 'socket' => 'LGA1700', 'ram' => 'DDR4'],
            ['sku' => 'MB-ASR-B560', 'name' => 'ASRock B560M Steel Legend', 'tipo' => 'Placa', 'precio_venta' => 110.00, 'socket' => 'LGA1200', 'ram' => 'DDR4'],

            // --- MEMORIAS RAM ---
            ['sku' => 'RAM-COR-16D4', 'name' => 'Corsair Vengeance LPX 16GB', 'tipo' => 'RAM', 'precio_venta' => 55.00, 'socket' => null, 'ram' => 'DDR4'],
            ['sku' => 'RAM-Gskill-32D4', 'name' => 'G.Skill Trident Z Neo 32GB', 'tipo' => 'RAM', 'precio_venta' => 115.00, 'socket' => null, 'ram' => 'DDR4'],
            ['sku' => 'RAM-Kin-8D4', 'name' => 'Kingston Fury Beast 8GB', 'tipo' => 'RAM', 'precio_venta' => 30.00, 'socket' => null, 'ram' => 'DDR4'],
            ['sku' => 'RAM-Cru-32D5', 'name' => 'Crucial RAM 32GB DDR5', 'tipo' => 'RAM', 'precio_venta' => 130.00, 'socket' => null, 'ram' => 'DDR5'],
            ['sku' => 'RAM-COR-16D5', 'name' => 'Corsair Dominator 16GB DDR5', 'tipo' => 'RAM', 'precio_venta' => 95.00, 'socket' => null, 'ram' => 'DDR5'],

            // --- OTROS ---
            ['sku' => 'GPU-NV-4070', 'name' => 'NVIDIA RTX 4070 Ti', 'tipo' => 'GPU', 'precio_venta' => 850.00, 'socket' => null, 'ram' => null],
            ['sku' => 'GPU-AMD-7800XT', 'name' => 'AMD Radeon RX 7800 XT', 'tipo' => 'GPU', 'precio_venta' => 550.00, 'socket' => null, 'ram' => null],
            ['sku' => 'SSD-SAM-980', 'name' => 'Samsung 980 Pro 1TB M.2', 'tipo' => 'SSD', 'precio_venta' => 105.00, 'socket' => null, 'ram' => null],
            ['sku' => 'PSU-COR-750', 'name' => 'Corsair RM750e 80+ Gold', 'tipo' => 'PSU', 'precio_venta' => 120.00, 'socket' => null, 'ram' => null],
            ['sku' => 'CASE-NZXT-H5', 'name' => 'NZXT H5 Flow Black', 'tipo' => 'Gabinete', 'precio_venta' => 95.00, 'socket' => null, 'ram' => null],
            ['sku' => 'COOL-NOT-D15', 'name' => 'Noctua NH-D15 Chromax', 'tipo' => 'Cooler', 'precio_venta' => 110.00, 'socket' => null, 'ram' => null],
            ['sku' => 'MON-LG-27', 'name' => 'LG UltraGear 27" 1440p', 'tipo' => 'Monitor', 'precio_venta' => 320.00, 'socket' => null, 'ram' => null],
            ['sku' => 'GPU-RTX4090-STRI','name' => 'ASUS ROG Strix GeForce RTX 4090', 'tipo' => 'GPU','precio_venta' => 1999.99],
            ['sku' => 'GPU-RTX4070-VENT','name' => 'MSI RTX 4070 Ventus 2X OC','tipo' => 'GPU','precio_venta' => 599.99],
            ['sku' => 'GPU-RX7800XT-PUL','name' => 'Sapphire Pulse AMD Radeon RX 7800 XT','tipo' => 'GPU','precio_venta' => 499.99],
            ['sku' => 'GPU-RX7600-SWFT','name' => 'XFX Speedster SWFT 210 Radeon RX 7600','tipo' => 'GPU','precio_venta' => 269.99],
            // --- PERIFÉRICOS ---
            ['sku' => 'PER-LOGI-G502','name' => 'Mouse Logitech G502 Hero RGB','tipo' => 'periferico','precio_venta' => 45.50],
            ['sku' => 'PER-RAZ-HUNT','name' => 'Teclado Mecánico Razer Huntsman V2','tipo' => 'periferico','precio_venta' => 149.99],
            ['sku' => 'PER-COR-HS80','name' => 'Auriculares Corsair HS80 RGB Wireless','tipo' => 'periferico','precio_venta' => 119.00],
            ['sku' => 'PER-STEE-QCK','name' => 'Mousepad SteelSeries QcK Heavy XXL','tipo' => 'periferico','precio_venta' => 29.99],
            ['sku' => 'PER-MON-VG24','name' => 'Monitor ASUS TUF Gaming 24" 165Hz','tipo' => 'periferico','precio_venta' => 189.99],

        ];

      foreach ($productos as $p) {
        // 1. Creamos el producto base
        $nuevoProducto = Product::create([
            'sku'          => $p['sku'],
            'name'         => $p['name'],
            'tipo'         => $p['tipo'],
            // Si no existe 'precio_venta', busca 'precio'. Si ninguno existe, pone 0.
            'precio_venta' => $p['precio_venta'] ?? $p['precio'] ?? 0
        ]);

    // 2. Extraemos socket y ram de forma segura
    // Si la llave no existe en el array (como en los periféricos), asigna null
    $socket = $p['socket'] ?? null;
    $ram    = $p['ram'] ?? null;

    // 3. Solo creamos compatibilidad si al menos uno tiene datos
    if ($socket || $ram) {
        Compatibility::create([ 
            'producto_id' => $nuevoProducto->id,
            'tipo_socket' => $socket,
            'tipo_ram'    => $ram
        ]);
    }
}
    }
}
