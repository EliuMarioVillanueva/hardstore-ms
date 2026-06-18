<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Product;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;

class VentaSeeder extends Seeder
{
    public function run(): void
    {
        // ============================================
        // 1. OBTENER DATOS EXISTENTES
        // ============================================
        $vendedores = User::where('rol', 'vendedor')->get();
        $clientes = User::where('rol', 'cliente')->get();
        $sucursales = Branch::all();
        $productos = Product::all();

        // Verificar que hay datos
        if ($vendedores->isEmpty()) {
            $this->command->error('⚠️ No hay vendedores. Ejecuta UsuarioSeeder primero.');
            return;
        }

        if ($clientes->isEmpty()) {
            $this->command->error('⚠️ No hay clientes. Ejecuta UsuarioSeeder primero.');
            return;
        }

        if ($sucursales->isEmpty()) {
            $this->command->error('⚠️ No hay sucursales. Ejecuta BranchSeeder primero.');
            return;
        }

        if ($productos->isEmpty()) {
            $this->command->error('⚠️ No hay productos. Ejecuta ProductSeeder primero.');
            return;
        }

        $this->command->info('📦 Generando 300 ventas...');
        $this->command->info("   - Vendedores disponibles: {$vendedores->count()}");
        $this->command->info("   - Clientes disponibles: {$clientes->count()}");

        // ============================================
        // 2. LIMPIAR TABLAS
        // ============================================
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Venta::truncate();
        DetalleVenta::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ============================================
        // 3. VENTAS DE VENDEDORES (200)
        // ============================================
        $this->command->info('Generando 200 ventas de VENDEDORES...');

        for ($i = 0; $i < 200; $i++) {
            $vendedor = $vendedores->random();
            $sucursal = $sucursales->random();
            $fecha = now()->subDays(rand(0, 90))->setTime(rand(8, 20), rand(0, 59), rand(0, 59));

            $venta = Venta::create([
                'usuario_id' => $vendedor->id,
                'sucursal_id' => $sucursal->id,
                'total' => 0,
                'fecha' => $fecha,
                'created_at' => $fecha,
                'updated_at' => $fecha,
            ]);

            $this->crearDetalles($venta, $productos, $fecha);

            if (($i + 1) % 50 == 0) {
                $this->command->info("   Vendedores: " . ($i + 1) . "/200");
            }
        }

        // ============================================
        // 4. VENTAS DE CLIENTES (100)
        // ============================================
        $this->command->info('Generando 100 ventas de CLIENTES...');

        for ($i = 0; $i < 100; $i++) {
            $cliente = $clientes->random();
            $sucursal = $sucursales->random();
            $fecha = now()->subDays(rand(0, 90))->setTime(rand(8, 20), rand(0, 59), rand(0, 59));

            $venta = Venta::create([
                'usuario_id' => $cliente->id,  // 👈 CLIENTE
                'sucursal_id' => $sucursal->id,
                'total' => 0,
                'fecha' => $fecha,
                'created_at' => $fecha,
                'updated_at' => $fecha,
            ]);

            $this->crearDetalles($venta, $productos, $fecha);

            if (($i + 1) % 25 == 0) {
                $this->command->info("   Clientes: " . ($i + 1) . "/100");
            }
        }

        // ============================================
        // 5. RESUMEN FINAL
        // ============================================
        $totalVentas = Venta::count();
        $totalIngresos = Venta::sum('total');
        $ventasVendedores = Venta::whereIn('usuario_id', $vendedores->pluck('id'))->count();
        $ventasClientes = Venta::whereIn('usuario_id', $clientes->pluck('id'))->count();

        $this->command->info('✅ Se crearon ' . $totalVentas . ' ventas.');
        $this->command->info("📊 Resumen:");
        $this->command->info("   - Ventas de vendedores: {$ventasVendedores}");
        $this->command->info("   - Ventas de clientes: {$ventasClientes}");
        $this->command->info("   - Ingresos totales: $" . number_format($totalIngresos, 0, ',', '.'));
    }

    // ============================================
    // MÉTODO AUXILIAR PARA CREAR DETALLES
    // ============================================
    private function crearDetalles($venta, $productos, $fecha)
    {
        $productosSeleccionados = $productos->random(rand(1, 4));
        $total = 0;

        foreach ($productosSeleccionados as $producto) {
            $cantidad = rand(1, 3);
            $subtotal = $producto->precio_venta * $cantidad;
            $total += $subtotal;

            DetalleVenta::create([
                'venta_id' => $venta->id,
                'producto_id' => $producto->id,
                'cantidad' => $cantidad,
                'precio_unitario_historico' => $producto->precio_venta,
                'created_at' => $fecha,
                'updated_at' => $fecha,
            ]);
        }

        $venta->update(['total' => $total]);
    }
}