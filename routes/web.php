<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController; 
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\PerfilVendedorController;

// 1. RUTA DE INICIO (pública)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// 2. RUTAS PÚBLICAS DE PRODUCTOS (solo lectura)
Route::get('/productos', [ProductController::class, 'index'])->name('productos.index');
Route::get('/productos/create', [ProductController::class, 'create'])->name('productos.create');
Route::get('/productos/{producto}', [ProductController::class, 'show'])->name('productos.show');

// 3. RUTAS PROTEGIDAS (requieren autenticación)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Perfil de vendedor
    Route::get('/perfil', [PerfilVendedorController::class, 'index'])->name('perfil.vendedor');
    Route::get('/perfil/editar', [PerfilVendedorController::class, 'edit'])->name('perfil.editar');
    Route::put('/perfil/update', [PerfilVendedorController::class, 'update'])->name('perfil.update');
    
    // 👇 AGREGAR ESTAS DOS LÍNEAS 👇
    Route::get('/perfil/reporte/inventario', [PerfilVendedorController::class, 'reporteInventario'])->name('perfil.reporte.inventario');
    Route::get('/perfil/reporte/ventas', [PerfilVendedorController::class, 'reporteVentas'])->name('perfil.reporte.ventas');
    
    // Productos (solo admin)
    Route::post('/productos', [ProductController::class, 'store'])->name('productos.store');
    
    // Inventario
    Route::get('/inventario', [ProductController::class, 'manageStock'])->name('productos.stock');
    Route::patch('/inventario/{id}', [ProductController::class, 'updateStock'])->name('productos.update_stock');
    Route::patch('/inventario-ajax/{id}', [ProductController::class, 'updateStockAjax'])->name('productos.update_stock_ajax');
    
    // Ventas
    Route::post('/ventas/express', [VentaController::class, 'storeExpress'])->name('ventas.store_express');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Reportes PDF
    Route::get('/reporte/ventas', [ReporteController::class, 'reporteVentas'])->name('reporte.ventas');
    Route::get('/reporte/inventario', [ReporteController::class, 'reporteInventario'])->name('reporte.inventario');
    
    // FACTURAS
    Route::get('/factura/generar/{venta}', [FacturaController::class, 'generarFactura'])->name('factura.generar');
    Route::get('/factura/descargar/{factura}', [FacturaController::class, 'descargarFactura'])->name('factura.descargar');
    Route::get('/factura/ver/{factura}', [FacturaController::class, 'verFactura'])->name('factura.ver');

});

// 4. RUTAS DE AUTENTICACIÓN (Breeze)
require __DIR__.'/auth.php';