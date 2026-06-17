<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Venta;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
       
        $fechaInicio = $request->get('fecha_inicio');
        $fechaFin = $request->get('fecha_fin');
        $rango = $request->get('rango', 'mes');
        
        // Si no hay fechas, mostrar el mes actual
        if (!$fechaInicio || !$fechaFin) {
            if ($rango == 'dia') {
                $fechaInicio = now()->toDateString();
                $fechaFin = now()->toDateString();
            } elseif ($rango == 'semana') {
                $fechaInicio = now()->startOfWeek()->toDateString();
                $fechaFin = now()->endOfWeek()->toDateString();
            } else { // mes
                $fechaInicio = now()->startOfMonth()->toDateString();
                $fechaFin = now()->toDateString();
            }
        }
        
        $ventasQuery = Venta::whereBetween('created_at', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59']);

        $totalProductos = Product::count();
        $totalVentas = $ventasQuery->sum('total');
        $totalUsuarios = User::count();
        $conteoGpus = Product::where('tipo', 'gpu')->count();
        
        // Ventas recientes (últimas 10 dentro del rango)
        $ventasRecientes = $ventasQuery->with(['usuario', 'sucursal'])->latest()->take(10)->get();
        
        // Ventas por sucursal dentro del rango
        $ventasPorSucursal = DB::table('branches')
            ->leftJoin('ventas', function($join) use ($fechaInicio, $fechaFin) {
                $join->on('branches.id', '=', 'ventas.sucursal_id')
                     ->whereBetween('ventas.created_at', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59']);
            })
            ->select('branches.name as sucursal', DB::raw('SUM(IFNULL(ventas.total, 0)) as total'))
            ->groupBy('branches.id', 'branches.name')
            ->get();
        
        return view('dashboard', compact(
            'totalProductos',
            'totalVentas',
            'ventasRecientes',
            'ventasPorSucursal',
            'totalUsuarios',
            'conteoGpus',
            'fechaInicio',
            'fechaFin',
            'rango'
        ));
    }
}