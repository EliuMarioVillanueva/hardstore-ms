<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Product;
use App\Models\User;
use App\Models\Descuento;
use App\Http\Controllers\FacturaController;

class VentaController extends Controller
{
    public function storeExpress(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        $total = $product->precio_venta * ($request->cantidad ?? 1);
        
        $descuentoId = $request->input('descuento_id');
        $descuentoAplicado = null;
        
        if ($descuentoId) {
            $descuento = Descuento::where('id', $descuentoId)
                ->where('user_id', auth()->id())
                ->where('usado', false)
                ->first();
            
            if ($descuento) {
                if ($descuento->tipo === 'porcentaje') {
                    $total = $total - ($total * $descuento->valor / 100);
                }
                $descuentoAplicado = $descuento;
            }
        }

        $venta = Venta::create([
            'usuario_id' => auth()->id(),
            'sucursal_id' => $request->sucursal_id,
            'total' => $total,
            'fecha' => now(),
            'estado' => 'pendiente',
            'metodo_pago' => 'transferencia',
        ]);

        $venta->detalles()->create([
            'producto_id' => $product->id,
            'cantidad' => $request->cantidad ?? 1,
            'precio_unitario_historico' => $product->precio_venta,
        ]);

        if ($descuentoAplicado) {
            $descuentoAplicado->update([
                'usado' => true,
                'usado_at' => now(),
            ]);
        }

        return redirect()->route('ventas.qr', $venta->id)
            ->with('success', 'Compra registrada. Realiza la transferencia para confirmar.');
    }

    public function qr($id)
    {
        $venta = Venta::with(['detalles.producto', 'sucursal', 'usuario'])->findOrFail($id);
        return view('ventas.qr-pago', compact('venta'));
    }

    public function index() { }
    public function create() { }
    public function store(Request $request) { }
    public function show(string $id) { }
    public function edit(string $id) { }
    public function update(Request $request, string $id) { }
    public function destroy(string $id) { }
}