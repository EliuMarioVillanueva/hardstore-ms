<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController; 
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\PerfilVendedorController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\VentaPendienteController; 
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AsistenteController;

// 1. RUTA DE INICIO (pública)
Route::get('/', [ComboController::class, 'index'])->name('welcome');

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
    
    Route::get('/perfil/reporte/inventario', [PerfilVendedorController::class, 'reporteInventario'])->name('perfil.reporte.inventario');
    Route::get('/perfil/reporte/ventas', [PerfilVendedorController::class, 'reporteVentas'])->name('perfil.reporte.ventas');
    
    // Productos (solo admin)
    Route::post('/productos', [ProductController::class, 'store'])->name('productos.store');
    
    // Inventario
    Route::get('/inventario', [ProductController::class, 'manageStock'])->name('productos.stock');
    Route::patch('/inventario/{id}', [ProductController::class, 'updateStock'])->name('productos.update_stock');
    Route::patch('/inventario-ajax/{id}', [ProductController::class, 'updateStockAjax'])->name('productos.update_stock_ajax');
    
    // Ventas (una sola vez)
    Route::post('/ventas/express', [VentaController::class, 'storeExpress'])->name('ventas.store_express');
    Route::get('/ventas/qr/{id}', [VentaController::class, 'qr'])->name('ventas.qr');
    
    // Ventas pendientes (vendedor)
    Route::get('/ventas-pendientes', [VentaPendienteController::class, 'index'])->name('ventas.pendientes');
    Route::post('/ventas-pendientes/{id}/confirmar', [VentaPendienteController::class, 'confirmar'])->name('ventas.confirmar');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Reportes PDF
    Route::get('/reporte/ventas', [ReporteController::class, 'reporteVentas'])->name('reporte.ventas');
    Route::get('/reporte/inventario', [ReporteController::class, 'reporteInventario'])->name('reporte.inventario');
    
    // FACTURAS
    Route::get('/factura/generar/{venta}', [FacturaController::class, 'generarFactura'])->name('factura.generar');
    Route::get('/factura/descargar/{factura}', [FacturaController::class, 'descargarFactura'])->name('factura.descargar');
    Route::get('/factura/ver/{factura}', [FacturaController::class, 'verFactura'])->name('factura.ver');

    Route::get('/mi-panel', [ClienteController::class, 'panel'])->name('cliente.panel');
    Route::get('/mi-panel/gacha', [ClienteController::class, 'gacha'])->name('cliente.gacha');
    Route::post('/mi-panel/gacha/tirar', [ClienteController::class, 'tirarGacha'])->name('cliente.gacha.tirar');
    Route::post('/mi-panel/favoritos/{producto}', [ClienteController::class, 'toggleFavorito'])->name('cliente.favoritos.toggle');
    
    // ASISTENTE IA - OLLAMA
    Route::post('/asistente/consulta', [AsistenteController::class, 'consulta'])->name('asistente.consulta');
});

// 4. RUTAS DE AUTENTICACIÓN (Breeze)
require __DIR__.'/auth.php';