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

        // Generar factura
        $facturaController = new FacturaController();
        $facturaController->generarFactura($venta);

        // Notificar al cliente (email)
        // Mail::to($venta->usuario->email)->send(new \App\Mail\CompraConfirmada($venta));

        return back()->with('success', 'Venta confirmada correctamente.');
    }
}w