<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function reporteVentas(Request $request)
    {
        // Obtener filtros de fecha (desde el dashboard)
        $fechaInicio = $request->get('fecha_inicio', now()->startOfMonth()->toDateString());
        $fechaFin = $request->get('fecha_fin', now()->toDateString());
        
        // Obtener sucursales con sus ventas filtradas por fecha
        $ventasPorSucursal = DB::table('branches')
            ->leftJoin('ventas', function($join) use ($fechaInicio, $fechaFin) {
                $join->on('branches.id', '=', 'ventas.sucursal_id')
                     ->whereBetween('ventas.created_at', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59']);
            })
            ->select('branches.id as sucursal_id', 'branches.name as sucursal', DB::raw('SUM(IFNULL(ventas.total, 0)) as total'))
            ->groupBy('branches.id', 'branches.name')
            ->get();
        
        // Generar PDF
        $pdf = Pdf::loadView('reportes.ventas-pdf', compact('ventasPorSucursal', 'fechaInicio', 'fechaFin'));
        
        // Configurar papel tamaño carta
        $pdf->setPaper('letter', 'portrait');
        
        // Mostrar en el navegador (vista previa)
        return $pdf->stream('reporte-ventas-' . now()->format('Y-m-d') . '.pdf');
    }
    
    public function reporteInventario()
    {
        $sucursales = \App\Models\Branch::all();
    
        $pdf = Pdf::loadView('reportes.inventario-pdf', compact('sucursales'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('reporte-inventario-' . now()->format('Y-m-d') . '.pdf');
    }
}