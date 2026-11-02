<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Product;
use App\Models\User;
use App\Http\Controllers\FacturaController;
use Illuminate\Support\Facades\Mail;

class VentaController extends Controller
{
    public function storeExpress(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // 1. Crear la Venta (estado pendiente)
        $venta = Venta::create([
            'usuario_id' => auth()->id(),
            'sucursal_id' => $request->sucursal_id,
            'total' => $product->precio_venta * ($request->cantidad ?? 1),
            'fecha' => now(),
            'estado' => 'pendiente',
            'metodo_pago' => 'transferencia',
        ]);

        // 2. Crear el Detalle
        $venta->detalles()->create([
            'producto_id' => $product->id,
            'cantidad' => $request->cantidad ?? 1,
            'precio_unitario_historico' => $product->precio_venta,
        ]);

        // 3. Notificar al vendedor de la sucursal (por email)
        $vendedor = User::where('rol', 'vendedor')
            ->where('sucursal_id', $request->sucursal_id)
            ->first();

        if ($vendedor) {
            // Mail::to($vendedor->email)->send(new \App\Mail\CompraPendiente($venta));
        }

        // 4. Redirigir a la vista del QR de pago
        return redirect()->route('ventas.qr', $venta->id)
            ->with('success', 'Compra registrada. Realiza la transferencia para confirmar.');
    }

    public function qr($id)
    {
        $venta = Venta::with(['detalles.producto', 'sucursal', 'usuario'])->findOrFail($id);
        
        return view('ventas.qr-pago', compact('venta'));
    }
}