<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Models\Branch;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request) 
    {
        $tipoSeleccionado = $request->query('tipo');
        $buscar = $request->query('buscar'); 

        $productos = Product::when($tipoSeleccionado, function ($query, $tipo) {
                return $query->where('tipo', $tipo);
            })
            ->when($buscar, function ($query, $term) {
                return $query->where('name', 'LIKE', '%' . $term . '%');
            })
            ->get();

        $categorias = Product::select('tipo')->distinct()->get();
        
        return view('productos.index', compact('productos', 'categorias', 'tipoSeleccionado', 'buscar'));
    }

    public function create()
    {
        $sucursales = Branch::all(); 
        return view('productos.create', compact('sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'tipo' => 'required',
            'precio_venta' => 'required|numeric|min:0',
            'cantidad_inicial' => 'required|integer|min:0',
            'sucursal_id' => 'required|exists:branches,id',
        ]);

        $producto = Product::create([
            'name' => $request->nombre,
            'sku' => $request->sku,
            'tipo' => $request->tipo,
            'precio_venta' => $request->precio_venta,
        ]);

        Stock::create([
            'producto_id' => $producto->id,
            'sucursal_id' => $request->sucursal_id,
            'cantidad' => $request->cantidad_inicial
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto registrado con stock.');
    }

    public function manageStock(Request $request)
    {
        $sucursales = Branch::all();
        $sucursalId = $request->query('sucursal_id', $sucursales->first()->id ?? 1);

        $productos = Product::with(['stocks' => function($query) use ($sucursalId) {
            $query->where('sucursal_id', $sucursalId);
        }, 'stocks.branch'])->get(); 

        return view('productos.stock', compact('productos', 'sucursales', 'sucursalId'));
    }

    /**
     * Muestra la ficha del producto con el selector de sucursales.
     */
    public function show($id)
    {
        // Traemos el producto con sus especificaciones y stock de cada sede
        $product = Product::with(['compatibility', 'stocks.branch'])->findOrFail($id);

        // Traemos las sucursales para el modal de compra express
        $sucursales = Branch::all(); 
        
        return view('productos.show', [
            'product' => $product,
            'sucursales' => $sucursales
        ]);
    }

    /**
     * ÚNICA versión de actualización de stock vía AJAX
     */
    public function updateStockAjax(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:0',
            'sucursal_id' => 'required|integer'
        ]);

        $stock = Stock::updateOrCreate(
            ['producto_id' => $id, 'sucursal_id' => $request->sucursal_id],
            ['cantidad' => $request->cantidad]
        );

        return response()->json(['success' => true]);
    }
}