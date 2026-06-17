<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inventario - {{ $sucursal->name }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #0095f6; }
        .header h1 { color: #0a0e27; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #0095f6; color: white; padding: 8px; text-align: left; }
        td { padding: 6px; border-bottom: 1px solid #ddd; }
        .text-center { text-align: center; }
        .footer { margin-top: 30px; text-align: center; font-size: 9px; color: #999; }
    </style>
</head>
<body>
    <div class="header">
        <h1>HardStore MS</h1>
        <p>Reporte de Inventario - {{ $sucursal->name }}</p>
        <p>Generado: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Producto</th>
                <th>Categoría</th>
                <th class="text-center">Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            @php $stockActual = $producto->stocks->first()->cantidad ?? 0; @endphp
            <tr>
                <td>{{ $producto->sku }}</td>
                <td>{{ $producto->name }}</td>
                <td>{{ $producto->tipo ?? 'Componente' }}</td>
                <td class="text-center">{{ $stockActual }} unidades</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        HardStore MS - Todos los derechos reservados
    </div>
</body>
</html>