<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Venta;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AsistenteController extends Controller
{
        public function consulta(Request $request)
    {
        $pregunta = trim($request->input('pregunta'));
        
        if (empty($pregunta)) {
            return response()->json(['respuesta' => 'Por favor, escribe una pregunta.']);
        }

        $user = Auth::user();
        
        if ($user && $user->rol === 'admin') {
            $respuesta = $this->procesarAdmin($pregunta);
        } else {
            $respuesta = $this->procesarCliente($pregunta);
        }
        
        \App\Models\ConsultaLog::create([
            'user_id' => $user ? $user->id : null,
            'pregunta' => $pregunta,
            'respuesta' => $respuesta
        ]);
        
        return response()->json(['respuesta' => $respuesta]);
    }
    
    private function procesarAdmin($pregunta)
    {
        $preguntaLower = strtolower($pregunta);
        
        if (str_contains($preguntaLower, 'vendió') || str_contains($preguntaLower, 'ventas totales')) {
            $total = Venta::sum('total');
            return "Las ventas totales son: $" . number_format($total, 0, ',', '.');
        }
        
        if (str_contains($preguntaLower, 'mejor vendedor') || str_contains($preguntaLower, 'vendedor top')) {
            $mejor = Venta::selectRaw('usuario_id, SUM(total) as total')
                ->groupBy('usuario_id')->orderBy('total', 'desc')->first();
            if ($mejor) {
                $vendedor = User::find($mejor->usuario_id);
                return "El mejor vendedor es {$vendedor->name} con $" . number_format($mejor->total, 0, ',', '.');
            }
            return "No hay ventas registradas aún.";
        }
        
        if (str_contains($preguntaLower, 'sucursal') && (str_contains($preguntaLower, 'vendió') || str_contains($preguntaLower, 'vendio') || str_contains($preguntaLower, 'más'))) {
            $mejorSucursal = Venta::selectRaw('sucursal_id, SUM(total) as total')
                ->groupBy('sucursal_id')->orderBy('total', 'desc')->first();
            if ($mejorSucursal) {
                $sucursal = \App\Models\Branch::find($mejorSucursal->sucursal_id);
                return "La sucursal que más vendió es **{$sucursal->name}** con $" . number_format($mejorSucursal->total, 0, ',', '.') . ".";
            }
            return "No hay ventas registradas aún.";
        }
        
        if (str_contains($preguntaLower, 'stock bajo') || str_contains($preguntaLower, 'agotar')) {
            $productos = Product::whereHas('stocks', fn($q) => $q->where('cantidad', '<', 5))->count();
            return "Hay {$productos} productos con stock bajo (menos de 5 unidades).";
        }
        
        if (str_contains($preguntaLower, 'cuántos clientes') || str_contains($preguntaLower, 'clientes')) {
            $clientes = User::where('rol', 'cliente')->count();
            return "Hay {$clientes} clientes registrados.";
        }
        
        if (str_contains($preguntaLower, 'cuántos productos') || str_contains($preguntaLower, 'total productos')) {
            $productos = Product::count();
            return "Hay {$productos} productos registrados en el catálogo.";
        }
        
        if (str_contains($preguntaLower, 'cuántas ventas') || str_contains($preguntaLower, 'total ventas')) {
            $ventas = Venta::count();
            return "Hay {$ventas} ventas registradas en el sistema.";
        }
        
        if (str_contains($preguntaLower, 'producto más vendido') || str_contains($preguntaLower, 'más vendido')) {
            $masVendido = \App\Models\DetalleVenta::selectRaw('producto_id, SUM(cantidad) as total')
                ->groupBy('producto_id')->orderBy('total', 'desc')->first();
            if ($masVendido) {
                $producto = Product::find($masVendido->producto_id);
                return "El producto más vendido es **{$producto->name}** con {$masVendido->total} unidades vendidas.";
            }
            return "No hay ventas registradas aún.";
        }
        
        if (str_contains($preguntaLower, 'ingresos') || str_contains($preguntaLower, 'ganancias')) {
            $total = Venta::sum('total');
            return "Los ingresos totales son: $" . number_format($total, 0, ',', '.');
        }
        
        if (str_contains($preguntaLower, 'promedio') && str_contains($preguntaLower, 'venta')) {
            $promedio = Venta::avg('total');
            return "El promedio por venta es: $" . number_format($promedio ?? 0, 0, ',', '.');
        }
        
        if (str_contains($preguntaLower, 'sucursales') || str_contains($preguntaLower, 'cuántas sucursales')) {
            $sucursales = \App\Models\Branch::count();
            return "Hay {$sucursales} sucursales registradas.";
        }
        
        if (str_contains($preguntaLower, 'vendedores') || str_contains($preguntaLower, 'cuántos vendedores')) {
            $vendedores = User::where('rol', 'vendedor')->count();
            return "Hay {$vendedores} vendedores registrados.";
        }
        
        if (str_contains($preguntaLower, 'stock total') || str_contains($preguntaLower, 'inventario total')) {
            $stock = \App\Models\Stock::sum('cantidad');
            return "El inventario total es de {$stock} unidades.";
        }
        
        if (str_contains($preguntaLower, 'producto con más stock') || str_contains($preguntaLower, 'más stock')) {
            $masStock = \App\Models\Stock::selectRaw('producto_id, SUM(cantidad) as total')
                ->groupBy('producto_id')->orderBy('total', 'desc')->first();
            if ($masStock) {
                $producto = Product::find($masStock->producto_id);
                return "El producto con más stock es **{$producto->name}** con {$masStock->total} unidades.";
            }
            return "No hay stock registrado.";
        }
        
        if (str_contains($preguntaLower, 'producto con menos stock') || str_contains($preguntaLower, 'menos stock')) {
            $menosStock = \App\Models\Stock::selectRaw('producto_id, SUM(cantidad) as total')
                ->groupBy('producto_id')->orderBy('total', 'asc')->first();
            if ($menosStock) {
                $producto = Product::find($menosStock->producto_id);
                return "El producto con menos stock es **{$producto->name}** con {$menosStock->total} unidades.";
            }
            return "No hay stock registrado.";
        }
        
        if (str_contains($preguntaLower, 'facturas') || str_contains($preguntaLower, 'cuántas facturas')) {
            $facturas = \App\Models\Factura::count();
            return "Hay {$facturas} facturas generadas.";
        }
        
        if (str_contains($preguntaLower, 'productos por agotarse') || str_contains($preguntaLower, 'por agotarse')) {
            $productos = Product::whereHas('stocks', fn($q) => $q->where('cantidad', '<', 5))->count();
            return "Hay {$productos} productos por agotarse (menos de 5 unidades).";
        }
                // Ventas del día
        if (str_contains($preguntaLower, 'vendió hoy') || str_contains($preguntaLower, 'ventas de hoy')) {
            $total = Venta::whereDate('created_at', now()->toDateString())->sum('total');
            return "Las ventas de hoy son: $" . number_format($total, 0, ',', '.');
        }
        
        // Ventas del mes
        if (str_contains($preguntaLower, 'vendió este mes') || str_contains($preguntaLower, 'ventas del mes')) {
            $total = Venta::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total');
            return "Las ventas de este mes son: $" . number_format($total, 0, ',', '.');
        }
        
        // Ventas pendientes
        if (str_contains($preguntaLower, 'pendientes') || str_contains($preguntaLower, 'por confirmar')) {
            $pendientes = Venta::where('estado', 'pendiente')->count();
            return "Hay **{$pendientes}** ventas pendientes de confirmación en este momento.";
        }
        
        // Mejor cliente
        if (str_contains($preguntaLower, 'mejor cliente') || str_contains($preguntaLower, 'cliente que más compra')) {
            $mejorCliente = Venta::selectRaw('usuario_id, SUM(total) as total')
                ->whereHas('usuario', fn($q) => $q->where('rol', 'cliente'))
                ->groupBy('usuario_id')
                ->orderBy('total', 'desc')
                ->first();
            if ($mejorCliente) {
                $cliente = User::find($mejorCliente->usuario_id);
                return "El mejor cliente es **{$cliente->name}** con un total de $" . number_format($mejorCliente->total, 0, ',', '.') . " en compras.";
            }
            return "No hay ventas de clientes registradas aún.";
        }
        
        // Venta más alta
        if (str_contains($preguntaLower, 'venta más alta') || str_contains($preguntaLower, 'venta más grande')) {
            $venta = Venta::orderBy('total', 'desc')->first();
            if ($venta) {
                return "La venta más alta fue la **#{$venta->id}** por un total de $" . number_format($venta->total, 0, ',', '.') . ".";
            }
            return "No hay ventas registradas.";
        }
        
        return $this->consultarOllama($pregunta);
    }
    
    private function procesarCliente($pregunta)
    {
        $preguntaLower = strtolower($pregunta);
        
        if (preg_match('/^(hola|buenas|hey|qué tal|que tal)/i', $preguntaLower)) {
            $nombre = Auth::check() ? Auth::user()->name : 'invitado';
            return "¡Hola, {$nombre}! Soy HardBot, tu asistente de HardStore MS. Puedo ayudarte a consultar precios, verificar stock, listar productos o recomendarte componentes para armar tu PC. ¿Qué necesitas?";
        }
        
        if (str_contains($preguntaLower, 'envío') || str_contains($preguntaLower, 'envio') || str_contains($preguntaLower, 'enviar')) {
            return "Hacemos envíos a toda Bolivia. El costo depende de tu ubicación y se calcula al finalizar la compra.";
        }
        
        if (str_contains($preguntaLower, 'garantía') || str_contains($preguntaLower, 'garantia')) {
            return "Todos nuestros productos tienen garantía oficial. Si tienes algún problema, contáctanos.";
        }
        
        if (str_contains($preguntaLower, 'cómo compro') || str_contains($preguntaLower, 'como compro')) {
    return "Para comprar: 1) Elige un producto, 2) Haz clic en 'Comprar ahora', 3) Selecciona tu sucursal, 4) Escanea el QR para transferir, 5) El vendedor confirmará tu pago.";
}

if (str_contains($preguntaLower, 'quiero comprar') || str_contains($preguntaLower, 'deseo comprar')) {
    return "¡Genial! Para comprar, ve al catálogo, elige el producto que te interesa y haz clic en 'Comprar ahora'. Si necesitas ayuda para encontrar algo, dime qué buscas.";
}
        
        if (str_contains($preguntaLower, 'método de pago') || str_contains($preguntaLower, 'pagar') || str_contains($preguntaLower, 'transferencia')) {
            return "Aceptamos transferencias bancarias. Al comprar, te mostramos un QR con los datos de la cuenta para que realices la transferencia. El vendedor confirmará tu pago.";
        }
        
        if (str_contains($preguntaLower, 'sucursal') || str_contains($preguntaLower, 'dónde están') || str_contains($preguntaLower, 'donde estan') || str_contains($preguntaLower, 'dirección')) {
            return "Tenemos 4 sucursales: Sede Central (Parque Industrial), Branch Norte (Centro Comercial), Branch Sur (Avenida Principal) y Punto de Venta Express (Terminal de Buses). Puedes ver las direcciones completas en el pie de página.";
        }
        
        if (str_contains($preguntaLower, 'horario') || str_contains($preguntaLower, 'hora')) {
            return "Nuestro horario de atención es de lunes a sábado de 8:00 a 20:00. Los domingos cerramos.";
        }
        
        if (str_contains($preguntaLower, 'contacto') || str_contains($preguntaLower, 'teléfono') || str_contains($preguntaLower, 'telefono')) {
            return "Puedes contactarnos al +56 2 1234 5678 o visitarnos en cualquiera de nuestras sucursales. También estamos en Instagram y Facebook.";
        }
        
        if (str_contains($preguntaLower, 'lista') && str_contains($preguntaLower, 'producto')) {
            return $this->listarProductosConTotal();
        }
        
        if (str_contains($preguntaLower, 'armar') || str_contains($preguntaLower, 'recomienda') || str_contains($preguntaLower, 'gaming') || str_contains($preguntaLower, 'presupuesto')) {
            return $this->recomendarPC($pregunta);
        }
        
        if (str_contains($preguntaLower, 'precio') || str_contains($preguntaLower, 'cuánto cuesta') || str_contains($preguntaLower, 'cuanto cuesta') || str_contains($preguntaLower, 'vale')) {
            return $this->buscarPrecio($pregunta);
        }
        
        if (str_contains($preguntaLower, 'stock') || str_contains($preguntaLower, 'disponible') || str_contains($preguntaLower, 'hay')) {
            return $this->buscarStock($pregunta);
        }
        
        if (str_contains($preguntaLower, 'procesador') || str_contains($preguntaLower, 'cpu')) {
            return $this->contarPorTipo('CPU', 'procesadores');
        }
        if (str_contains($preguntaLower, 'gabinete') || str_contains($preguntaLower, 'case')) {
            return $this->contarPorTipo('Gabinete', 'gabinetes');
        }
        if (str_contains($preguntaLower, 'tarjeta') || str_contains($preguntaLower, 'gpu') || str_contains($preguntaLower, 'gráfica')) {
            return $this->contarPorTipo('GPU', 'tarjetas gráficas');
        }
        if (str_contains($preguntaLower, 'ram') || str_contains($preguntaLower, 'memoria')) {
            return $this->contarPorTipo('RAM', 'memorias RAM');
        }
        if (str_contains($preguntaLower, 'placa') || str_contains($preguntaLower, 'motherboard')) {
            return $this->contarPorTipo('Placa', 'placas base');
        }
        if (str_contains($preguntaLower, 'monitor') || str_contains($preguntaLower, 'pantalla')) {
            return $this->contarPorTipo('Monitor', 'monitores');
        }
        if (str_contains($preguntaLower, 'ssd') || str_contains($preguntaLower, 'almacenamiento')) {
            return $this->contarPorTipo('SSD', 'almacenamientos');
        }
        if (str_contains($preguntaLower, 'periferico') || str_contains($preguntaLower, 'mouse') || str_contains($preguntaLower, 'teclado')) {
            return $this->contarPorTipo('periferico', 'periféricos');
        }
        if (str_contains($preguntaLower, 'fuente') || str_contains($preguntaLower, 'psu')) {
            return $this->contarPorTipo('PSU', 'fuentes de poder');
        }
        if (str_contains($preguntaLower, 'cooler') || str_contains($preguntaLower, 'refrigeración')) {
            return $this->contarPorTipo('Cooler', 'coolers');
        }
        
        if (str_contains($preguntaLower, 'más barato') || str_contains($preguntaLower, 'economico') || str_contains($preguntaLower, 'barato')) {
            $producto = Product::orderBy('precio_venta', 'asc')->first();
            if ($producto) {
                return "El producto más económico es **{$producto->name}** a $" . number_format($producto->precio_venta, 0, ',', '.') . ".";
            }
            return "No hay productos registrados.";
        }
        
        if (str_contains($preguntaLower, 'más caro') || str_contains($preguntaLower, 'caro')) {
            $producto = Product::orderBy('precio_venta', 'desc')->first();
            if ($producto) {
                return "El producto más caro es **{$producto->name}** a $" . number_format($producto->precio_venta, 0, ',', '.') . ".";
            }
            return "No hay productos registrados.";
        }
        
        if (str_contains($preguntaLower, 'descuento') || str_contains($preguntaLower, 'promoción')) {
            return "Tenemos un sistema de puntos: por cada $10 que gastes, ganas 1 punto. Al acumular 100 puntos, puedes tirar el gacha y ganar descuentos del 5%, 10%, 15% o envío gratis. ¡Visita tu panel de cliente para más detalles!";
        }
        
        if (str_contains($preguntaLower, 'puntos') || str_contains($preguntaLower, 'gacha')) {
            return "Ganas 1 punto por cada $10 de compra. Al llegar a 100 puntos, puedes tirar el gacha en tu panel de cliente y ganar descuentos. ¡Sigue comprando para acumular más!";
        }
        
        if (str_contains($preguntaLower, 'favorito') || str_contains($preguntaLower, 'guardar')) {
            return "Puedes guardar productos como favoritos desde la página de detalles de cada producto. Solo haz clic en el corazón y aparecerán en tu panel de cliente.";
        }
        
        if (str_contains($preguntaLower, 'factura') || str_contains($preguntaLower, 'comprobante')) {
            return "Al confirmar tu compra, el vendedor generará una factura electrónica que podrás descargar desde tu panel de cliente.";
        }
        
        if (str_contains($preguntaLower, 'devolución') || str_contains($preguntaLower, 'devolucion') || str_contains($preguntaLower, 'reembolso')) {
            return "Si tienes algún problema con tu producto, contáctanos dentro de los primeros 7 días para gestionar un cambio o devolución. Aplican términos y condiciones.";
        }
        
        if (str_contains($preguntaLower, 'compatibilidad') || str_contains($preguntaLower, 'compatible')) {
            return $this->recomendarCompatible($pregunta);
        }

                // ============================================
        // NUEVOS CASOS DE USO
        // ============================================

        // Preguntar por el producto más barato o más caro
        if (str_contains($preguntaLower, 'más barato') || str_contains($preguntaLower, 'mas barato') || str_contains($preguntaLower, 'económico') || str_contains($preguntaLower, 'economico')) {
            $producto = Product::orderBy('precio_venta', 'asc')->first();
            if ($producto) {
                return "El producto más económico que tenemos es **{$producto->name}** a \${$producto->precio_venta}.";
            }
            return "No hay productos registrados.";
        }

        if (str_contains($preguntaLower, 'más caro') || str_contains($preguntaLower, 'mas caro') || str_contains($preguntaLower, 'caro')) {
            $producto = Product::orderBy('precio_venta', 'desc')->first();
            if ($producto) {
                return "El producto más caro que tenemos es **{$producto->name}** a \${$producto->precio_venta}.";
            }
            return "No hay productos registrados.";
        }

        if (str_contains($preguntaLower, 'marcas') || str_contains($preguntaLower, 'marca')) {
            return "Trabajamos con las mejores marcas del mercado: AMD, Intel, NVIDIA, ASUS, MSI, Gigabyte, Corsair, Kingston y más. ¿Buscas alguna en específico?";
        }

        if (str_contains($preguntaLower, 'sucursal') || str_contains($preguntaLower, 'dónde están') || str_contains($preguntaLower, 'donde estan') || str_contains($preguntaLower, 'dirección')) {
            return "Tenemos 4 sucursales: Sede Central (Parque Industrial), Branch Norte (Centro Comercial), Branch Sur (Avenida Principal) y Punto de Venta Express (Terminal de Buses). Puedes ver las direcciones completas en el pie de página.";
        }

        if (str_contains($preguntaLower, 'horario') || str_contains($preguntaLower, 'hora')) {
            return "Nuestro horario de atención es de lunes a sábado de 8:00 a 20:00. Los domingos cerramos.";
        }

        if (str_contains($preguntaLower, 'contacto') || str_contains($preguntaLower, 'teléfono') || str_contains($preguntaLower, 'telefono')) {
            return "Puedes contactarnos al +56 2 1234 5678 o visitarnos en cualquiera de nuestras sucursales. También estamos en Instagram y Facebook.";
        }

        if (str_contains($preguntaLower, 'pago') || str_contains($preguntaLower, 'pagar') || str_contains($preguntaLower, 'transferencia')) {
            return "Aceptamos transferencias bancarias. Al comprar, te mostramos un QR con los datos de la cuenta para que realices la transferencia. El vendedor confirmará tu pago.";
        }

        if (str_contains($preguntaLower, 'garantía') || str_contains($preguntaLower, 'garantia')) {
            return "Todos nuestros productos tienen garantía oficial. Si tienes algún problema, contáctanos y te ayudamos.";
        }

        if (str_contains($preguntaLower, 'devolución') || str_contains($preguntaLower, 'devolucion') || str_contains($preguntaLower, 'reembolso')) {
            return "Si tienes algún problema con tu producto, contáctanos dentro de los primeros 7 días para gestionar un cambio o devolución. Aplican términos y condiciones.";
        }

        if (str_contains($preguntaLower, 'quién eres') || str_contains($preguntaLower, 'quien eres') || str_contains($preguntaLower, 'tu nombre')) {
            return "Soy HardBot, el asistente virtual de HardStore MS. Estoy aquí para ayudarte a encontrar productos, consultar precios y armar tu PC ideal. ¿Qué necesitas?";
        }

        if (str_contains($preguntaLower, 'promoción') || str_contains($preguntaLower, 'promocion') || str_contains($preguntaLower, 'descuento')) {
            return "Tenemos un sistema de puntos: por cada $10 que gastes, ganas 1 punto. Al acumular 100 puntos, puedes tirar el gacha y ganar descuentos del 5%, 10%, 15% o envío gratis. ¡Visita tu panel de cliente para más detalles!";
        }

        if (str_contains($preguntaLower, 'mi pedido') || str_contains($preguntaLower, 'mi compra') || str_contains($preguntaLower, 'mi orden')) {
            $user = Auth::user();
            if ($user) {
                $ultimaCompra = Venta::where('usuario_id', $user->id)->latest()->first();
                if ($ultimaCompra) {
                    $estado = $ultimaCompra->estado === 'completado' ? '✅ Completado' : '⏳ Pendiente de confirmación';
                    return "Tu última compra fue la **#{$ultimaCompra->id}** por un total de \${$ultimaCompra->total}. El estado actual es: **{$estado}**. Puedes ver más detalles en tu panel de cliente.";
                }
                return "No encontré compras registradas a tu nombre. ¿Quizás quieres ver el catálogo?";
            }
            return "Para consultar tu pedido, primero debes iniciar sesión.";
        }

        if (str_contains($preguntaLower, 'socket') || str_contains($preguntaLower, 'núcleos') || str_contains($preguntaLower, 'especificaciones')) {
            $producto = Product::where('name', 'LIKE', '%' . $this->extraerProducto($pregunta) . '%')
                ->with('compatibility')
                ->first();
            
            if ($producto && $producto->compatibility) {
                $specs = "Especificaciones del **{$producto->name}**:\n\n";
                if ($producto->compatibility->tipo_socket) $specs .= "🔹 Socket: {$producto->compatibility->tipo_socket}\n";
                if ($producto->compatibility->tipo_ram) $specs .= "🔹 Tipo de RAM: {$producto->compatibility->tipo_ram}\n";
                return $specs;
            }
            return "No encontré especificaciones técnicas para ese producto. ¿Puedes darme el nombre exacto?";
        }

        if (str_contains($preguntaLower, 'diferencia') || str_contains($preguntaLower, 'comparar') || str_contains($preguntaLower, 'mejor')) {
            // Buscar si menciona AMD e Intel, o dos productos
            if (str_contains($preguntaLower, 'amd') && str_contains($preguntaLower, 'intel')) {
                return "AMD suele ofrecer mejor rendimiento en tareas multinúcleo y mejores precios, mientras que Intel destaca en juegos y tiene un mayor consumo energético. En HardStore MS tenemos opciones de ambas marcas. ¿Quieres que te muestre precios?";
            }
            if (str_contains($preguntaLower, 'ryzen 5') && str_contains($preguntaLower, 'ryzen 7')) {
                return "El **Ryzen 5** es ideal para gaming y tareas diarias, mientras que el **Ryzen 7** es superior para edición de video y renderizado. La diferencia de precio vale la pena si haces tareas pesadas.";
            }
        }

        if (str_contains($preguntaLower, 'no enciende') || str_contains($preguntaLower, 'no da imagen') || str_contains($preguntaLower, 'pantalla negra')) {
            return "Si tu PC no enciende o no da imagen, te recomiendo verificar:\n\n1. Que el cable de poder esté bien conectado.\n2. Que la fuente de poder tenga el interruptor encendido.\n3. Que la RAM esté bien insertada (prueba con un solo módulo).\n\nSi el problema persiste, puedes traerlo a nuestra Sede Central para revisión técnica.";
        }

        if (str_contains($preguntaLower, 'qué categorías') || str_contains($preguntaLower, 'que categorias') || str_contains($preguntaLower, 'tipos de productos')) {
            $categorias = Product::select('tipo')->distinct()->pluck('tipo')->implode(', ');
            return "En HardStore MS tenemos las siguientes categorías: **{$categorias}**. ¿Qué tipo de componente estás buscando?";
        }

        if (str_contains($preguntaLower, 'háblame de') || str_contains($preguntaLower, 'hablame de') || str_contains($preguntaLower, 'información de')) {
            $producto = Product::where('name', 'LIKE', '%' . $this->extraerProducto($pregunta) . '%')->first();
            if ($producto) {
                return "El **{$producto->name}** es un componente de tipo **{$producto->tipo}** con un precio de **\${$producto->precio_venta}**. Su SKU es {$producto->sku}. ¿Quieres saber si hay stock o si es compatible con tu equipo?";
            }
        }

        return $this->consultarOllama($pregunta);
    }
    
private function recomendarCompatible($pregunta)
{
    $preguntaLower = strtolower($pregunta);
    
    $productoBase = null;
    $tipoBase = null;
    
    if (str_contains($preguntaLower, 'ryzen') || str_contains($preguntaLower, 'intel') || str_contains($preguntaLower, 'cpu')) {
        $productoBase = Product::where('tipo', 'CPU')
            ->where('name', 'LIKE', '%' . $this->extraerProducto($pregunta) . '%')
            ->with('compatibility')
            ->first();
        $tipoBase = 'CPU';
    } elseif (str_contains($preguntaLower, 'b550') || str_contains($preguntaLower, 'x570') || str_contains($preguntaLower, 'b650') || str_contains($preguntaLower, 'placa')) {
        $productoBase = Product::where('tipo', 'Placa')
            ->where('name', 'LIKE', '%' . $this->extraerProducto($pregunta) . '%')
            ->with('compatibility')
            ->first();
        $tipoBase = 'Placa';
    }
    
    if (!$productoBase) {
        return "No encontré ese producto. ¿Puedes ser más específico? (Ej: Ryzen 5 5600X, B550, RTX 4070)";
    }
    
    $presupuesto = null;
    if (preg_match('/(\$?\s*(\d+)\s*(dólares|dolares|bolivianos|bs|usd|\$)?)/i', $pregunta, $matches)) {
        $presupuesto = (int) $matches[2];
    }
    
    $socket = $productoBase->compatibility->tipo_socket ?? null;
    $tipoRam = $productoBase->compatibility->tipo_ram ?? null;
    
    $compatibles = [];
    
    if ($tipoBase === 'CPU') {
        if ($socket) {
            $placas = Product::where('tipo', 'Placa')
                ->whereHas('compatibility', fn($q) => $q->where('tipo_socket', $socket))
                ->when($presupuesto, fn($q) => $q->where('precio_venta', '<=', $presupuesto * 0.3))
                ->orderBy('precio_venta', 'desc')
                ->take(2)
                ->get();
            
            foreach ($placas as $p) {
                $compatibles[] = "🔹 Placa: {$p->name} (\${$p->precio_venta})";
            }
        }
        
        if ($tipoRam) {
            $rams = Product::where('tipo', 'RAM')
                ->whereHas('compatibility', fn($q) => $q->where('tipo_ram', $tipoRam))
                ->when($presupuesto, fn($q) => $q->where('precio_venta', '<=', $presupuesto * 0.2))
                ->orderBy('precio_venta', 'desc')
                ->take(2)
                ->get();
            
            foreach ($rams as $r) {
                $compatibles[] = "🔹 RAM: {$r->name} (\${$r->precio_venta})";
            }
        }
    }
    
    if ($tipoBase === 'Placa') {
        if ($socket) {
            $cpus = Product::where('tipo', 'CPU')
                ->whereHas('compatibility', fn($q) => $q->where('tipo_socket', $socket))
                ->when($presupuesto, fn($q) => $q->where('precio_venta', '<=', $presupuesto * 0.5))
                ->orderBy('precio_venta', 'desc')
                ->take(2)
                ->get();
            
            foreach ($cpus as $c) {
                $compatibles[] = "🔹 CPU: {$c->name} (\${$c->precio_venta})";
            }
        }
        
        if ($tipoRam) {
            $rams = Product::where('tipo', 'RAM')
                ->whereHas('compatibility', fn($q) => $q->where('tipo_ram', $tipoRam))
                ->when($presupuesto, fn($q) => $q->where('precio_venta', '<=', $presupuesto * 0.3))
                ->orderBy('precio_venta', 'desc')
                ->take(2)
                ->get();
            
            foreach ($rams as $r) {
                $compatibles[] = "🔹 RAM: {$r->name} (\${$r->precio_venta})";
            }
        }
    }
    
    if (count($compatibles) > 0) {
        $lista = implode("\n", $compatibles);
        $mensaje = "El {$productoBase->name} es compatible con:\n\n{$lista}";
        
        if ($presupuesto) {
            $mensaje .= "\n\n💡 Presupuesto considerado: \${$presupuesto}";
        }
        
        return $mensaje;
    }
    
    return "No encontré componentes compatibles con el {$productoBase->name}. ¿Quieres que busque alternativas?";
}

    private function listarProductosConTotal()
    {
        $productos = Product::take(10)->get();
        $lista = "";
        $total = 0;
        foreach ($productos as $p) {
            $lista .= "- {$p->name}: $" . number_format($p->precio_venta, 0, ',', '.') . "\n";
            $total += $p->precio_venta;
        }
        return "Estos son algunos de nuestros productos:\n{$lista}\nTotal (10 productos): $" . number_format($total, 0, ',', '.');
    }
    
private function recomendarPC($pregunta)
{
    if (preg_match('/(\$?\s*(\d+)\s*(dólares|dolares|bolivianos|bs|usd|\$)?)/i', $pregunta, $matches)) {
        $presupuesto = (int) $matches[2];
        
        if ($presupuesto < 100) {
            return "¡Claro! Para recomendarte los mejores componentes, ¿cuál es tu presupuesto aproximado? (Ej: 1000 dólares, 5000 bolivianos)";
        }
        
        $preguntaLower = strtolower($pregunta);
        $incluyePerifericos = str_contains($preguntaLower, 'periferico') || 
                              str_contains($preguntaLower, 'periférico') ||
                              str_contains($preguntaLower, 'mouse') ||
                              str_contains($preguntaLower, 'teclado') ||
                              str_contains($preguntaLower, 'monitor');
        
        $total = 0;
        $componentes = [];
        
        $cpu = Product::where('tipo', 'CPU')
            ->where('precio_venta', '<=', $presupuesto * 0.35)
            ->orderBy('precio_venta', 'desc')
            ->first();
        
        if ($cpu) {
            $total += $cpu->precio_venta;
            $componentes[] = [
                'icono' => '🔹',
                'nombre' => 'CPU',
                'producto' => $cpu->name,
                'precio' => $cpu->precio_venta,
            ];
            
            $socket = $cpu->compatibility->tipo_socket ?? null;
            $tipoRam = $cpu->compatibility->tipo_ram ?? null;
            
            if ($socket) {
                $placa = Product::where('tipo', 'Placa')
                    ->where('precio_venta', '<=', $presupuesto * 0.2)
                    ->whereHas('compatibility', fn($q) => $q->where('tipo_socket', $socket))
                    ->orderBy('precio_venta', 'desc')
                    ->first();
                
                if ($placa) {
                    $total += $placa->precio_venta;
                    $componentes[] = [
                        'icono' => '🔹',
                        'nombre' => 'Placa',
                        'producto' => $placa->name,
                        'precio' => $placa->precio_venta,
                    ];
                }
            }
            
            if ($tipoRam) {
                $ram = Product::where('tipo', 'RAM')
                    ->where('precio_venta', '<=', $presupuesto * 0.15)
                    ->whereHas('compatibility', fn($q) => $q->where('tipo_ram', $tipoRam))
                    ->orderBy('precio_venta', 'desc')
                    ->first();
                
                if ($ram) {
                    $total += $ram->precio_venta;
                    $componentes[] = [
                        'icono' => '🔹',
                        'nombre' => 'RAM',
                        'producto' => $ram->name,
                        'precio' => $ram->precio_venta,
                    ];
                }
            }
        }
        
        $gpu = Product::where('tipo', 'GPU')
            ->where('precio_venta', '<=', $presupuesto * 0.4)
            ->orderBy('precio_venta', 'desc')
            ->first();
        
        if ($gpu) {
            $total += $gpu->precio_venta;
            $componentes[] = [
                'icono' => '🎮',
                'nombre' => 'GPU',
                'producto' => $gpu->name,
                'precio' => $gpu->precio_venta,
            ];
        }
        
        $restante = $presupuesto - $total;
        
        if ($restante > 0) {
            $ssd = Product::where('tipo', 'SSD')
                ->where('precio_venta', '<=', $restante * 0.5)
                ->orderBy('precio_venta', 'desc')
                ->first();
            
            if ($ssd) {
                $total += $ssd->precio_venta;
                $componentes[] = [
                    'icono' => '💿',
                    'nombre' => 'SSD',
                    'producto' => $ssd->name,
                    'precio' => $ssd->precio_venta,
                ];
            }
        }
        
        if ($incluyePerifericos) {
            $restante = $presupuesto - $total;
            
            $monitor = Product::where('tipo', 'Monitor')
                ->where('precio_venta', '<=', $restante * 0.4)
                ->orderBy('precio_venta', 'desc')
                ->first();
            
            if ($monitor) {
                $total += $monitor->precio_venta;
                $componentes[] = [
                    'icono' => '🖥️',
                    'nombre' => 'Monitor',
                    'producto' => $monitor->name,
                    'precio' => $monitor->precio_venta,
                ];
            }
            
            $restante = $presupuesto - $total;
            
            $teclado = Product::where('tipo', 'periferico')
                ->where('name', 'LIKE', '%teclado%')
                ->where('precio_venta', '<=', $restante * 0.5)
                ->orderBy('precio_venta', 'desc')
                ->first();
            
            if ($teclado) {
                $total += $teclado->precio_venta;
                $componentes[] = [
                    'icono' => '⌨️',
                    'nombre' => 'Teclado',
                    'producto' => $teclado->name,
                    'precio' => $teclado->precio_venta,
                ];
            }
            
            $restante = $presupuesto - $total;
            
            $mouse = Product::where('tipo', 'periferico')
                ->where('name', 'LIKE', '%mouse%')
                ->where('name', 'NOT LIKE', '%mousepad%')
                ->where('precio_venta', '<=', $restante * 0.5)
                ->orderBy('precio_venta', 'desc')
                ->first();
            
            if ($mouse) {
                $total += $mouse->precio_venta;
                $componentes[] = [
                    'icono' => '🖱️',
                    'nombre' => 'Mouse',
                    'producto' => $mouse->name,
                    'precio' => $mouse->precio_venta,
                ];
            }
        }
        
        if (count($componentes) > 0) {
            $lineas = "";
            foreach ($componentes as $c) {
                $lineas .= "{$c['icono']} {$c['nombre']}: {$c['producto']}\n   \${$c['precio']}\n\n";
            }
            
            $mensaje = "🖥️ **COTIZACIÓN DE PC - HARDSTORE MS**\n\n";
$mensaje .= "Presupuesto: \${$presupuesto}\n\n";
$mensaje .= "**COMPONENTES RECOMENDADOS:**\n\n";
$mensaje .= $lineas;
$mensaje .= "💰 **TOTAL ESTIMADO: \${$total}**\n";
            
            if ($total < $presupuesto * 0.8) {
                $mensaje .= "\n💡 Te quedan $" . number_format($presupuesto - $total, 0, ',', '.') . " disponibles.";
            } elseif ($total > $presupuesto) {
                $mensaje .= "\n⚠️ El total supera tu presupuesto por $" . number_format($total - $presupuesto, 0, ',', '.') . ".";
            }
            
            $mensaje .= "\n\n¿Quieres que ajuste algún componente?";
            
            return $mensaje;
        }
        
        return "No encontré componentes disponibles para tu presupuesto. ¿Puedes intentar con otro monto?";
    }
    
    return "¡Claro! Para recomendarte los mejores componentes, ¿cuál es tu presupuesto aproximado? (Ej: 1000 dólares, 5000 bolivianos)";
}
    
    private function buscarPrecio($pregunta)
    {
        $producto = Product::where('name', 'LIKE', '%' . $this->extraerProducto($pregunta) . '%')->first();
        
        if ($producto) {
            return "El {$producto->name} cuesta $" . number_format($producto->precio_venta, 0, ',', '.') . ".";
        }
        
        return "No encontré ese producto. ¿Puedes ser más específico? (Ej: Ryzen 5 5600X, RTX 4070)";
    }
    
    private function buscarStock($pregunta)
    {
        $producto = Product::where('name', 'LIKE', '%' . $this->extraerProducto($pregunta) . '%')
            ->with('stocks')->first();
        
        if ($producto) {
            $stockTotal = $producto->stocks->sum('cantidad');
            if ($stockTotal > 0) {
                return "Sí, tenemos {$stockTotal} unidades de {$producto->name} disponibles.";
            }
            return "Lo siento, no hay stock de {$producto->name} en este momento.";
        }
        
        return "No encontré ese producto. ¿Puedes ser más específico?";
    }
    
    private function contarPorTipo($tipo, $nombrePlural)
{
    $productos = Product::where('tipo', $tipo)->take(5)->get();
    $total = Product::where('tipo', $tipo)->count();
    
    if ($total > 0) {
        $lista = "";
        foreach ($productos as $p) {
            $lista .= "- {$p->name} (\${$p->precio_venta})\n";
        }
        
        $mensaje = "Sí, tenemos {$total} modelos de {$nombrePlural} disponibles. Algunos son:\n\n{$lista}";
        if ($total > 5) {
            $mensaje .= "\n... y otros más. ¿Te interesa alguno en particular?";
        }
        return $mensaje;
    }
    
    return "Lo siento, no tenemos {$nombrePlural} disponibles en este momento.";
}
    
    private function extraerProducto($pregunta)
    {
        $palabras = ['ryzen', 'intel', 'rtx', 'radeon', 'corsair', 'kingston', 'asus', 'msi', 'amd', 'nvidia'];
        foreach ($palabras as $palabra) {
            if (str_contains(strtolower($pregunta), $palabra)) {
                return $palabra;
            }
        }
        return '';
    }
    
    private function consultarOllama($pregunta)
{
    try {
                $prompt = "Eres HardBot, el asistente virtual de la tienda de hardware HardStore MS.
        REGLAS ESTRICTAS:
        1. Responde de forma breve, amable y útil en español.
        2. Solo puedes responder preguntas relacionadas con hardware de computadoras, componentes o la tienda HardStore MS.
        3. Si el usuario pregunta sobre política, cocina, programación, historia o cualquier otro tema NO relacionado con la tienda, DEBES responder exactamente: 'Lo siento, mi conocimiento se limita exclusivamente a hardware y a los productos de HardStore MS. ¿Te puedo ayudar a armar tu PC o buscar algún componente?'.
        4. NUNCA inventes productos o precios que no existan.

        Pregunta del cliente: {$pregunta}";;
        
        $response = Http::withoutVerifying()->timeout(120)->post('http://127.0.0.1:11434/api/generate', [
    'model' => 'llama3.2:1b',
    'prompt' => $prompt,
    'stream' => false,
]);
        
        if ($response->successful()) {
            $data = $response->json();
            return $data['response'] ?? 'Lo siento, no pude procesar tu consulta.';
        }
        
        // Si Ollama responde con error, mostrar el código
        return "Error de Ollama (código " . $response->status() . "). Intenta de nuevo.";
        
    } catch (\Exception $e) {
        \Log::error('Error en Ollama: ' . $e->getMessage());
        // 👇 Mostrar el error real para diagnosticar
        return "Error de conexión: " . $e->getMessage();
    }
}
}