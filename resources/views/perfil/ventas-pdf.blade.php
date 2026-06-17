<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ventas - {{ $sucursal->name }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #0095f6; }
        .header h1 { color: #0a0e27; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #0095f6; color: white; padding: 8px; text-align: left; }
        td { padding: 6px; border-bottom: 1px solid #ddd; }
        .text-right { text-align: right; }
        .total { margin-top: 20px; text-align: right; font-weight: bold; font-size: 14px; }
        .footer { margin-top: 30px; text-align: center; font-size: 9px; color: #999; }
    </style>
</head>
<body>
    <div class="header">
        <h1>HardStore MS</h1>
        <p>Reporte de Ventas - {{ $sucursal->name }}</p>
        <p>Período: {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Vendedor</th>
                <th>Producto</th>
                <th>Cant.</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
                @foreach($venta->detalles as $detalle)
                <tr>
                    <td>#{{ $venta->id }}</td>
                    <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $venta->usuario->name ?? 'N/A' }}</td>
                    <td>{{ $detalle->producto->name ?? 'Producto' }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td class="text-right">${{ number_format($detalle->cantidad * $detalle->precio_unitario_historico, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    
    <div class="total">
        Total Ventas: ${{ number_format($totalVentas, 0, ',', '.') }}
    </div>
    
    <div class="footer">
        HardStore MS - Todos los derechos reservados
    </div>
</body>
</html>