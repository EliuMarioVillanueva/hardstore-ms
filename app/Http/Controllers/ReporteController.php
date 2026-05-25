<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function reporteVentas()
    {
        // Obtener sucursales con sus ventas (necesitamos el ID para la relación)
        $ventasPorSucursal = DB::table('branches')
            ->leftJoin('ventas', 'branches.id', '=', 'ventas.sucursal_id')
            ->select('branches.id as sucursal_id', 'branches.name as sucursal', DB::raw('SUM(IFNULL(ventas.total, 0)) as total'))
            ->groupBy('branches.id', 'branches.name')
            ->get();
        
        // Generar PDF
        $pdf = Pdf::loadView('reportes.ventas-pdf', compact('ventasPorSucursal'));
        
        // Configurar papel tamaño carta
        $pdf->setPaper('letter', 'portrait');
        
        // Descargar con nombre personalizado
        return $pdf->download('reporte-detallado-ventas-' . now()->format('Y-m-d') . '.pdf');
    }
    public function reporteInventario()
    {
        $sucursales = \App\Models\Branch::all();
    
        $pdf = Pdf::loadView('reportes.inventario-pdf', compact('sucursales'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->download('reporte-inventario-' . now()->format('Y-m-d') . '.pdf');
    }
}