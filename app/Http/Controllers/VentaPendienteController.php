<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;

class VentaPendienteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $sucursalId = $user->sucursal_id;

        $ventasPendientes = Venta::with(['usuario', 'detalles.producto', 'sucursal'])
            ->where('sucursal_id', $sucursalId)
            ->where('estado', 'pendiente')
            ->latest()
            ->get();

        $ventasConfirmadas = Venta::with(['usuario', 'detalles.producto', 'sucursal'])
            ->where('sucursal_id', $sucursalId)
            ->where('estado', 'completado')
            ->latest()
            ->take(10)
            ->get();

        return view('vendedor.pendientes', compact('ventasPendientes', 'ventasConfirmadas'));
    }

    public function confirmar($id)
{
    $venta = Venta::findOrFail($id);
    
    $venta->update([
        'estado' => 'completado',
        'confirmado_at' => now(),
        'confirmado_por' => Auth::id(),
    ]);

    // 👇 DAR PUNTOS AL CLIENTE
    $puntos = \App\Models\Punto::firstOrCreate(
        ['user_id' => $venta->usuario_id],
        ['cantidad' => 0, 'total_acumulado' => 0]
    );
    
    // 1 punto por cada $10
    $puntosGanados = floor($venta->total / 10);
    $puntos->cantidad += $puntosGanados;
    $puntos->total_acumulado += $puntosGanados;
    $puntos->save();

    // Generar factura
    $facturaController = new FacturaController();
    $facturaController->generarFactura($venta);

    return back()->with('success', 'Venta confirmada. El cliente ganó ' . $puntosGanados . ' puntos.');
}
}