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
    ini_set('memory_limit', '512M');
    
    $ventasPorSucursal = DB::table('branches')
        ->leftJoin('ventas', 'branches.id', '=', 'ventas.sucursal_id')
        ->select('branches.id as sucursal_id', 'branches.name as sucursal', DB::raw('SUM(IFNULL(ventas.total, 0)) as total'))
        ->groupBy('branches.id', 'branches.name')
        ->limit(50)
        ->get();
    
    $pdf = Pdf::loadView('reportes.ventas-pdf', compact('ventasPorSucursal'));
    $pdf->setPaper('letter', 'portrait');
    return $pdf->stream('reporte-detallado-ventas-' . now()->format('Y-m-d') . '.pdf');
}

    public function reporteInventario()
    {
        $sucursales = \App\Models\Branch::all();
        $pdf = Pdf::loadView('reportes.inventario-pdf', compact('sucursales'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('reporte-inventario-' . now()->format('Y-m-d') . '.pdf');
    }

    public function reporteVentasFiltrado(Request $request)
    {
        ini_set('memory_limit', '256M');
        
        $fechaInicio = $request->get('fecha_inicio', now()->startOfMonth()->toDateString());
        $fechaFin = $request->get('fecha_fin', now()->toDateString());

        $ventas = Venta::with(['usuario', 'sucursal', 'detalles.producto'])
            ->whereBetween('created_at', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $totalVentas = $ventas->sum('total');
        $cantidadVentas = $ventas->count();

        $ventasPorSucursal = DB::table('branches')
            ->leftJoin('ventas', function($join) use ($fechaInicio, $fechaFin) {
                $join->on('branches.id', '=', 'ventas.sucursal_id')
                     ->whereBetween('ventas.created_at', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59']);
            })
            ->select('branches.name as sucursal', DB::raw('SUM(IFNULL(ventas.total, 0)) as total'))
            ->groupBy('branches.id', 'branches.name')
            ->get();

        $pdf = Pdf::loadView('reportes.ventas-filtrado-pdf', compact(
            'ventas', 'fechaInicio', 'fechaFin', 'totalVentas', 'cantidadVentas', 'ventasPorSucursal'
        ));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('reporte-ventas-filtrado-' . now()->format('Y-m-d') . '.pdf');
    }
}