<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class PerfilVendedorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
    // 👇 VERIFICAR QUE SEA VENDEDOR O ADMIN
    if (!in_array($user->rol, ['vendedor', 'admin'])) {
        return redirect()->route('cliente.panel')->with('error', 'No tienes permiso para acceder a esta sección.');
    }
    
    $sucursalId = $user->sucursal_id;

        $user = Auth::user();
        $sucursalId = $user->sucursal_id;
        
        // ========== ESTADÍSTICAS DE LA SUCURSAL ==========
        $ventasSucursal = Venta::where('sucursal_id', $sucursalId);
        $totalVentasSucursal = $ventasSucursal->sum('total');
        $cantidadVentasSucursal = $ventasSucursal->count();
        
        // Productos vendidos en la sucursal
        $productosVendidosSucursal = Venta::where('sucursal_id', $sucursalId)
            ->with('detalles')
            ->get()
            ->sum(function($venta) {
                return $venta->detalles->sum('cantidad');
            });
        
        // ========== INVENTARIO DE LA SUCURSAL ==========
        $productos = Product::whereHas('stocks', function($query) use ($sucursalId) {
            $query->where('sucursal_id', $sucursalId);
        })->with(['stocks' => function($query) use ($sucursalId) {
            $query->where('sucursal_id', $sucursalId);
        }])->get();
        
        $totalProductos = $productos->count();
        $totalUnidades = $productos->sum(function($p) {
            return $p->stocks->first()->cantidad ?? 0;
        });
        $productosBajoStock = $productos->filter(function($p) {
            return ($p->stocks->first()->cantidad ?? 0) < 5;
        })->count();
        
        // ========== VENTAS RECIENTES DE LA SUCURSAL ==========
        $ventasRecientes = Venta::with('usuario', 'detalles.producto')
            ->where('sucursal_id', $sucursalId)
            ->latest()
            ->take(10)
            ->get();
        
        // ========== VENTAS PENDIENTES DE LA SUCURSAL ==========
        $ventasPendientes = Venta::with(['usuario', 'detalles.producto', 'sucursal'])
            ->where('sucursal_id', $sucursalId)
            ->where('estado', 'pendiente')
            ->latest()
            ->get();
        
        return view('perfil.vendedor', compact(
            'user', 'sucursalId', 'totalVentasSucursal', 'cantidadVentasSucursal',
            'productosVendidosSucursal', 'productos', 'totalProductos', 
            'totalUnidades', 'productosBajoStock', 'ventasRecientes',
            'ventasPendientes'
        ));
    }
    
    public function reporteInventario()
    {
            $user = Auth::user();
    if (!in_array($user->rol, ['vendedor', 'admin'])) {
        return redirect()->route('cliente.panel');
    }
        $user = Auth::user();
        $sucursalId = $user->sucursal_id;
        
        if (!$sucursalId) {
            return redirect()->back()->with('error', 'No tienes una sucursal asignada.');
        }
        
        $sucursal = \App\Models\Branch::find($sucursalId);
        
        if (!$sucursal) {
            return redirect()->back()->with('error', 'La sucursal asignada no existe.');
        }
        
        $productos = Product::whereHas('stocks', function($query) use ($sucursalId) {
            $query->where('sucursal_id', $sucursalId);
        })->with(['stocks' => function($query) use ($sucursalId) {
            $query->where('sucursal_id', $sucursalId);
        }])->get();
        
        $pdf = Pdf::loadView('perfil.inventario-pdf', compact('productos', 'sucursal'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('inventario-' . $sucursal->name . '-' . now()->format('Y-m-d') . '.pdf');
    }
    
    public function reporteVentas(Request $request)
    {
            $user = Auth::user();
    if (!in_array($user->rol, ['vendedor', 'admin'])) {
        return redirect()->route('cliente.panel');
    }
        $user = Auth::user();
        $sucursalId = $user->sucursal_id;
        
        if (!$sucursalId) {
            return redirect()->back()->with('error', 'No tienes una sucursal asignada.');
        }
        
        $sucursal = \App\Models\Branch::find($sucursalId);
        
        if (!$sucursal) {
            return redirect()->back()->with('error', 'La sucursal asignada no existe.');
        }
        
        $fechaInicio = $request->get('fecha_inicio', now()->startOfMonth()->toDateString());
        $fechaFin = $request->get('fecha_fin', now()->toDateString());
        
        $ventas = Venta::with('usuario', 'detalles.producto')
            ->where('sucursal_id', $sucursalId)
            ->whereBetween('created_at', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->get();
        
        $totalVentas = $ventas->sum('total');
        
        $pdf = Pdf::loadView('perfil.ventas-pdf', compact('ventas', 'sucursal', 'fechaInicio', 'fechaFin', 'totalVentas'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('ventas-' . $sucursal->name . '-' . now()->format('Y-m-d') . '.pdf');
    }
    
    public function edit()
    {
            $user = Auth::user();
    if (!in_array($user->rol, ['vendedor', 'admin'])) {
        return redirect()->route('cliente.panel');
    }
        $user = Auth::user();
        return view('perfil.editar', compact('user'));
    }
    
    public function update(Request $request)
    {
            $user = Auth::user();
    if (!in_array($user->rol, ['vendedor', 'admin'])) {
        return redirect()->route('cliente.panel');
    }
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return redirect()->route('perfil.vendedor')->with('success', 'Perfil actualizado correctamente.');
    }
}