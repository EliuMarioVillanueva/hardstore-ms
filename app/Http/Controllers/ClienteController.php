<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Product;
use App\Models\Favorito;
use App\Models\Punto;
use App\Models\Descuento;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function panel()
    {
        $user = Auth::user();
        
        // Historial de compras
        $compras = Venta::with(['detalles.producto', 'sucursal'])
            ->where('usuario_id', $user->id)
            ->latest()
            ->get();
        
        // Favoritos
        $favoritos = Favorito::with('producto')
            ->where('user_id', $user->id)
            ->get();
        
        // Puntos
        $puntos = Punto::firstOrCreate(
            ['user_id' => $user->id],
            ['cantidad' => 0, 'total_acumulado' => 0]
        );
        
        // Descuentos activos
        $descuentos = Descuento::where('user_id', $user->id)
            ->where('usado', false)
            ->get();
        
        return view('cliente.panel', compact('user', 'compras', 'favoritos', 'puntos', 'descuentos'));
    }
    
    public function gacha()
    {
        $user = Auth::user();
        $puntos = Punto::firstOrCreate(
            ['user_id' => $user->id],
            ['cantidad' => 0, 'total_acumulado' => 0]
        );
        
        return view('cliente.gacha', compact('user', 'puntos'));
    }
    
    public function tirarGacha()
    {
        $user = Auth::user();
        $puntos = Punto::firstOrCreate(
            ['user_id' => $user->id],
            ['cantidad' => 0, 'total_acumulado' => 0]
        );
        
        // Verificar si tiene puntos suficientes
        if ($puntos->cantidad < 100) {
            return redirect()->back()->with('error', 'Necesitas al menos 100 puntos para tirar el gacha.');
        }
        
        // Restar puntos
        $puntos->cantidad -= 100;
        $puntos->save();
        
        // Premios posibles con probabilidades
        $premios = [
            ['tipo' => 'porcentaje', 'valor' => 5, 'probabilidad' => 50],
            ['tipo' => 'porcentaje', 'valor' => 10, 'probabilidad' => 30],
            ['tipo' => 'porcentaje', 'valor' => 15, 'probabilidad' => 15],
            ['tipo' => 'envio_gratis', 'valor' => 0, 'probabilidad' => 5],
        ];
        
        // Seleccionar premio aleatorio
        $random = rand(1, 100);
        $acumulado = 0;
        $premioSeleccionado = null;
        
        foreach ($premios as $premio) {
            $acumulado += $premio['probabilidad'];
            if ($random <= $acumulado) {
                $premioSeleccionado = $premio;
                break;
            }
        }
        
        // Guardar descuento
        $descuento = Descuento::create([
            'user_id' => $user->id,
            'tipo' => $premioSeleccionado['tipo'],
            'valor' => $premioSeleccionado['valor'],
            'usado' => false,
        ]);
        
        return redirect()->route('cliente.panel')
            ->with('success', '¡Ganaste ' . $descuento->descripcion . '!');
    }
    
    public function toggleFavorito($productoId)
    {
        $user = Auth::user();
        
        $favorito = Favorito::where('user_id', $user->id)
            ->where('producto_id', $productoId)
            ->first();
        
        if ($favorito) {
            $favorito->delete();
            return redirect()->back()->with('success', 'Producto eliminado de favoritos.');
        } else {
            Favorito::create([
                'user_id' => $user->id,
                'producto_id' => $productoId,
            ]);
            return redirect()->back()->with('success', 'Producto añadido a favoritos.');
        }
    }
}