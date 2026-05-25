<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Product;
use App\Http\Controllers\FacturaController; // 👈 AGREGAR ESTO

class VentaController extends Controller
{
    public function storeExpress(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // 1. Crear la Venta
        $venta = Venta::create([
            'usuario_id' => auth()->id(),
            'sucursal_id' => $request->sucursal_id,
            'total' => $product->precio_venta * ($request->cantidad ?? 1),
            'fecha' => now(),
        ]);

        // 2. Crear el Detalle
        $venta->detalles()->create([
            'producto_id' => $product->id,
            'cantidad' => $request->cantidad ?? 1,
            'precio_unitario_historico' => $product->precio_venta,
        ]);

        // 3. 👇 GENERAR FACTURA AUTOMÁTICAMENTE 👇
        $facturaController = new FacturaController();
        $pdf = $facturaController->generarFactura($venta);
        
        // Opcional: Guardar el PDF físicamente o devolverlo como descarga
        // Por ahora, solo generamos la factura y la guardamos en el servidor

        // 4. Redirigir con mensaje de éxito
        return back()->with('success', '¡Venta realizada! La factura se ha generado correctamente.');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    
}
