<?php

namespace App\Observers;

use App\Models\DetalleVenta;
use App\Models\Stock;

class DetalleVentaObserver
{
    /**
     * Se ejecuta una sola vez al crear el detalle.
     */
    public function created(DetalleVenta $detalleVenta): void
    {
        // Prioridad: 1. Sucursal elegida en el modal, 2. Sucursal del usuario
        $sucursalId = request('sucursal_id') ?? ($detalleVenta->venta->usuario->sucursal_id ?? null);

        if ($sucursalId) {
            // Una sola ejecución de decremento
            Stock::where('producto_id', $detalleVenta->producto_id)
                ->where('sucursal_id', $sucursalId)
                ->decrement('cantidad', $detalleVenta->cantidad);
        }
    }
}