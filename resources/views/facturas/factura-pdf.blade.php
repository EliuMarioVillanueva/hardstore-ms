<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Factura - HardStore MS</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            margin: 20px;
            background: white;
        }
        
        /* Logo */
        .logo-section {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .logo-box {
            background: linear-gradient(135deg, #0095f6, #00c3ff);
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }
        
        .logo-box span {
            color: white;
            font-size: 28px;
            font-weight: 800;
        }
        
        .logo-text {
            font-size: 20px;
            font-weight: 800;
            color: #0a0e27;
        }
        
        .logo-sub {
            font-size: 9px;
            color: #666;
        }
        
        /* Tabla de productos */
        .productos-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        .productos-table th {
            background: #2c3e50;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 9px;
        }
        
        .productos-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 9px;
        }
        
        .text-right {
            text-align: right;
        }
        
        .totales {
            width: 300px;
            margin-left: auto;
            margin-top: 15px;
        }
        
        .totales tr td {
            padding: 4px;
        }
        
        .total-final {
            font-weight: bold;
            font-size: 12px;
            color: #0095f6;
        }
        
        .footer {
            position: fixed;
            bottom: 15px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 8px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
    </style>
</head>
<body>
    <!-- Logo -->
    <div class="logo-section">
        <div class="logo-box">
            <span>H</span>
        </div>
        <div class="logo-text">HARDSTORE MS</div>
        <div class="logo-sub">Hardware de Alto Rendimiento</div>
    </div>

    <!-- Información de factura en TABLA (lado a lado) -->
    <table style="width: 100%; margin: 20px 0; background: #f8f9fa; border-radius: 8px;">
        <tr>
            <!-- Columna izquierda: SUCURSAL DE COMPRA -->
            <td style="width: 50%; padding: 15px; vertical-align: top;">
                <div style="font-weight: bold; color: #0095f6; margin-bottom: 8px; font-size: 10px; text-transform: uppercase;">SUCURSAL DE COMPRA</div>
                <div style="margin-bottom: 4px; font-size: 12px; font-weight: bold;">{{ $venta->sucursal->name ?? 'No especificada' }}</div>
                <div style="margin-top: 12px; margin-bottom: 4px; font-size: 10px;"><strong>Método de pago:</strong> Pago contra entrega</div>
                <div style="margin-bottom: 4px; font-size: 10px;"><strong>Forma de retiro:</strong> Retiro en tienda</div>
            </td>
            
            <!-- Columna derecha: Factura y Cliente -->
            <td style="width: 50%; padding: 15px; vertical-align: top; text-align: right;">
                <div style="font-weight: bold; color: #0095f6; margin-bottom: 8px; font-size: 10px; text-transform: uppercase;">FACTURA ELECTRÓNICA</div>
                <div style="margin-bottom: 4px; font-size: 10px;"><strong>N°:</strong> {{ $factura->numero_factura }}</div>
                <div style="margin-bottom: 4px; font-size: 10px;"><strong>Fecha emisión:</strong> {{ $factura->created_at->format('d/m/Y H:i') }}</div>
                <div style="margin-top: 8px; margin-bottom: 4px; font-size: 10px;"><strong>Cliente:</strong> {{ $venta->usuario->name }}</div>
                <div style="margin-bottom: 4px; font-size: 10px;"><strong>Email:</strong> {{ $venta->usuario->email }}</div>
            </td>
        </tr>
    </table>

    <!-- Tabla de productos -->
    <table class="productos-table">
        <thead>
            <tr>
                <th>Cant.</th>
                <th>Producto</th>
                <th>SKU</th>
                <th class="text-right">Precio Unit.</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->detalles as $detalle)
            <tr>
                <td>{{ $detalle->cantidad }}</td>
                <td>{{ $detalle->producto->name ?? 'Producto' }}</td>
                <td>{{ $detalle->producto->sku ?? 'N/A' }}</td>
                <td class="text-right">${{ number_format($detalle->precio_unitario_historico, 0, ',', '.') }}</td>
                <td class="text-right">${{ number_format($detalle->cantidad * $detalle->precio_unitario_historico, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totales -->
    <table class="totales">
        <tr>
            <td width="70%"></td>
            <td class="text-right">Subtotal:</td>
            <td class="text-right">${{ number_format($venta->total / 1.19, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td></td>
            <td class="text-right">IVA (19%):</td>
            <td class="text-right">${{ number_format($venta->total - ($venta->total / 1.19), 0, ',', '.') }}</td>
        </tr>
        <tr class="total-final">
            <td></td>
            <td class="text-right">TOTAL:</td>
            <td class="text-right">${{ number_format($venta->total, 0, ',', '.') }}</td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="footer">
        HardStore MS - Factura Electrónica | Documento generado por computador | www.hardstorems.cl
    </div>
</body>
</html>