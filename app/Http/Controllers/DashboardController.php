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
    public function index()
    {
        // 1. Estadísticas para las tarjetas superiores
        $totalProductos = Product::count();
        $totalVentas = Venta::sum('total');
        $totalUsuarios = User::count(); // <--- Esto faltaba
        $conteoGpus = Product::where('tipo', 'gpu')->count(); // <--- Esto faltaba
        
        $ventasRecientes = Venta::with(['usuario', 'sucursal'])->latest()->take(10)->get();

        // 2. Consulta corregida para el gráfico por sucursal
        // Ahora usamos la relación directa 'sucursal_id' en la tabla ventas
        $ventasPorSucursal = DB::table('branches')
            ->leftJoin('ventas', 'branches.id', '=', 'ventas.sucursal_id')
            ->select('branches.name as sucursal', DB::raw('SUM(IFNULL(ventas.total, 0)) as total'))
            ->groupBy('branches.id', 'branches.name')
            ->get();

        return view('dashboard', compact(
            'totalProductos', 
            'totalVentas', 
            'ventasRecientes', 
            'ventasPorSucursal',
            'totalUsuarios',
            'conteoGpus'
        ));
    }
}