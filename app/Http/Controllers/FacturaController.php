<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class FacturaController extends Controller
{
    public function generarFactura(Venta $venta)
    {
        // Verificar si ya existe factura
        $factura = Factura::where('venta_id', $venta->id)->first();
        
        if (!$factura) {
            // Crear nueva factura
            $factura = Factura::create([
                'venta_id' => $venta->id,
                'numero_factura' => Factura::generarNumero(),
                'total' => $venta->total,
                'estado' => 'emitida'
            ]);
        }
        
        // Generar PDF
        $pdf = Pdf::loadView('facturas.factura-pdf', compact('factura', 'venta'));
        
        // Guardar PDF en el servidor
        $ruta = "facturas/{$factura->numero_factura}.pdf";
        Storage::disk('public')->put($ruta, $pdf->output());
        
        // Actualizar ruta en la base de datos
        $factura->update(['ruta_pdf' => $ruta]);
        
        return $pdf;
    }
    
    public function descargarFactura(Factura $factura)
    {
        // Cargar la relación venta
        $factura->load('venta');
        
        if ($factura->ruta_pdf && Storage::disk('public')->exists($factura->ruta_pdf)) {
            return Storage::disk('public')->download($factura->ruta_pdf, "Factura-{$factura->numero_factura}.pdf");
        }
        
        // Si no existe el archivo, regenerar
        $pdf = Pdf::loadView('facturas.factura-pdf', [
            'factura' => $factura,
            'venta' => $factura->venta
        ]);
        
        return $pdf->download("Factura-{$factura->numero_factura}.pdf");
    }
    
    public function verFactura(Factura $factura)
    {
        // Cargar la relación venta
        $factura->load('venta');
        
        if ($factura->ruta_pdf && Storage::disk('public')->exists($factura->ruta_pdf)) {
            return response()->file(Storage::disk('public')->path($factura->ruta_pdf));
        }
        
        $pdf = Pdf::loadView('facturas.factura-pdf', [
            'factura' => $factura,
            'venta' => $factura->venta
        ]);
        
        return $pdf->stream("Factura-{$factura->numero_factura}.pdf");
    }
    
}