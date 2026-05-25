<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inventario - HardStore MS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            background: white;
            font-size: 11px;
            margin: 20px;
        }
        
        /* Encabezado principal de cada página */
        .main-header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #0095f6;
        }
        
        .main-header h1 {
            color: #0a0e27;
            font-size: 22px;
            margin: 0;
            letter-spacing: 1px;
        }
        
        .main-header p {
            color: #666;
            font-size: 10px;
            margin: 3px 0 0;
        }
        
        .fecha-generacion {
            text-align: right;
            font-size: 9px;
            color: #999;
            margin-bottom: 20px;
        }
        
        /* Cada sucursal comienza en una nueva página */
        .branch-report {
            page-break-before: always;
            margin-bottom: 20px;
        }
        
        .branch-report:first-child {
            page-break-before: avoid;
        }
        
        /* Encabezado de sucursal - MÁS ARRIBA Y MÁS VISIBLE */
        .branch-header {
    background-color: #0095f6;
    color: white;
    padding: 12px 15px;
    border-radius: 8px;
    margin-top: 5px;
    text-align: center;
}

.branch-header h2 {
    margin: 0;
    font-size: 18px;
    font-weight: bold;
    letter-spacing: 1px;
    color: white;
}

.branch-header p {
    margin: 5px 0 0;
    font-size: 9px;
    color: rgba(255, 255, 255, 0.9);
}
        
        /* Tabla de inventario */
        .inventario-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .inventario-table th {
            background: #2c3e50;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .inventario-table td {
            padding: 6px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 9px;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        /* Badges de stock */
        .stock-bajo {
            color: #dc3545;
            font-weight: bold;
        }
        
        .stock-medio {
            color: #ffc107;
            font-weight: bold;
        }
        
        .stock-alto {
            color: #28a745;
            font-weight: bold;
        }
        
        /* Total de sucursal */
        .total-branch {
            text-align: right;
            margin-top: 12px;
            padding-top: 8px;
            border-top: 2px solid #0095f6;
            font-weight: bold;
            font-size: 11px;
        }
        
        /* Resumen de la sucursal */
        .resumen-sucursal {
            margin-top: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 6px;
            display: flex;
            justify-content: space-around;
            text-align: center;
        }
        
        .resumen-item {
            flex: 1;
        }
        
        .resumen-label {
            font-size: 8px;
            color: #666;
            text-transform: uppercase;
        }
        
        .resumen-value {
            font-size: 14px;
            font-weight: bold;
            color: #0095f6;
        }
        
        /* Pie de página fijo */
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
        
        /* Resumen global al final */
        .global-summary {
            page-break-before: always;
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        
        .global-summary h3 {
            color: #0095f6;
            margin-bottom: 15px;
            font-size: 14px;
            text-align: center;
        }
        
        .global-table {
            width: 60%;
            margin: 0 auto;
            border-collapse: collapse;
        }
        
        .global-table th {
            background: #0095f6;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        
        .global-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        
        .global-total {
            background: #f0f0f0;
            font-weight: bold;
        }
        
        .page-number:after {
            content: counter(page);
        }
    </style>
</head>
<body>

@foreach($sucursales as $index => $sucursal)
    @php
        $productosConStock = \App\Models\Product::whereHas('stocks', function($query) use ($sucursal) {
            $query->where('sucursal_id', $sucursal->id);
        })->with(['stocks' => function($query) use ($sucursal) {
            $query->where('sucursal_id', $sucursal->id);
        }])->get();
        
        $totalProductos = $productosConStock->count();
        $totalUnidades = $productosConStock->sum(function($p) {
            $stock = $p->stocks->first();
            return $stock ? $stock->cantidad : 0;
        });
        $productosBajoStock = $productosConStock->filter(function($p) {
            $stock = $p->stocks->first();
            return $stock ? $stock->cantidad < 5 : false;
        })->count();
    @endphp
    
    <div class="branch-report">
        <!-- HardStore arriba -->
        <div class="main-header">
            <h1> HardStore MS</h1>
            <p>Hardware de Alto Rendimiento | Reporte de Inventario</p>
        </div>
        
        <div class="fecha-generacion">
            Generado: {{ now()->format('d/m/Y H:i:s') }} | Usuario: {{ auth()->user()->name }}
        </div>
        
        <!-- NOMBRE DE SUCURSAL ARRIBA (justo antes de la tabla) -->
        <div class="branch-header">
            <h2> {{ strtoupper($sucursal->name) }}</h2>
            <p>Código: SUC-{{ str_pad($sucursal->id, 3, '0', STR_PAD_LEFT) }} | Fecha de corte: {{ now()->format('d/m/Y') }}</p>
        </div>
        
        @if($productosConStock->count() > 0)
            <!-- Tabla de inventario -->
            <table class="inventario-table">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th class="text-center">Precio</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productosConStock as $producto)
                        @php
                            $stockActual = $producto->stocks->first()->cantidad ?? 0;
                            if($stockActual >= 20) {
                                $stockClass = 'stock-alto';
                                $stockEstado = 'ALTO';
                            } elseif($stockActual >= 5) {
                                $stockClass = 'stock-medio';
                                $stockEstado = 'MEDIO';
                            } else {
                                $stockClass = 'stock-bajo';
                                $stockEstado = 'BAJO';
                            }
                        @endphp
                        <tr>
                            <td>{{ $producto->sku }}</td>
                            <td>{{ $producto->name }}</td>
                            <td>{{ $producto->tipo ?? 'Componente' }}</td>
                            <td class="text-center">${{ number_format($producto->precio_venta, 0, ',', '.') }}</td>
                            <td class="text-center {{ $stockClass }}">{{ $stockActual }} unidades</td>
                            <td class="text-center {{ $stockClass }}">{{ $stockEstado }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <!-- Total de sucursal -->
            <div class="total-branch">
                 TOTAL {{ strtoupper($sucursal->name) }}: {{ $totalProductos }} productos | {{ $totalUnidades }} unidades
            </div>
            
            <!-- Resumen de la sucursal -->
            <div class="resumen-sucursal">
                <div class="resumen-item">
                    <div class="resumen-label"> TOTAL PRODUCTOS</div>
                    <div class="resumen-value">{{ $totalProductos }}</div>
                </div>
                <div class="resumen-item">
                    <div class="resumen-label"> UNIDADES TOTALES</div>
                    <div class="resumen-value">{{ $totalUnidades }}</div>
                </div>
                <div class="resumen-item">
                    <div class="resumen-label"> STOCK BAJO (&lt;5)</div>
                    <div class="resumen-value" style="color: #dc3545;">{{ $productosBajoStock }}</div>
                </div>
            </div>
        @else
            <p style="text-align: center; padding: 30px; color: #999;">
                No hay productos registrados en esta sucursal
            </p>
        @endif
    </div>
@endforeach

<!-- Resumen Global al final -->
<div class="global-summary">
    <h3> Resumen General de Inventario</h3>
    <table class="global-table">
        <thead>
            <tr>
                <th>Sucursal</th>
                <th class="text-right">Productos</th>
                <th class="text-right">Unidades</th>
                <th class="text-right">Stock Bajo</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $globalProductos = 0;
                $globalUnidades = 0;
                $globalStockBajo = 0;
            @endphp
            @foreach($sucursales as $sucursal)
                @php
                    $productosConStock = \App\Models\Product::whereHas('stocks', function($query) use ($sucursal) {
                        $query->where('sucursal_id', $sucursal->id);
                    })->with(['stocks' => function($query) use ($sucursal) {
                        $query->where('sucursal_id', $sucursal->id);
                    }])->get();
                    
                    $totalProductos = $productosConStock->count();
                    $totalUnidades = $productosConStock->sum(function($p) {
                        $stock = $p->stocks->first();
                        return $stock ? $stock->cantidad : 0;
                    });
                    $productosBajoStock = $productosConStock->filter(function($p) {
                        $stock = $p->stocks->first();
                        return $stock ? $stock->cantidad < 5 : false;
                    })->count();
                    
                    $globalProductos += $totalProductos;
                    $globalUnidades += $totalUnidades;
                    $globalStockBajo += $productosBajoStock;
                @endphp
                <tr>
                    <td>{{ $sucursal->name }}</td>
                    <td class="text-right">{{ $totalProductos }}</td>
                    <td class="text-right">{{ $totalUnidades }}</td>
                    <td class="text-right" style="color: #dc3545;">{{ $productosBajoStock }}</td>
                </tr>
            @endforeach
            <tr class="global-total">
                <td><strong>GRAN TOTAL</strong></td>
                <td class="text-right"><strong>{{ $globalProductos }}</strong></td>
                <td class="text-right"><strong>{{ $globalUnidades }}</strong></td>
                <td class="text-right"><strong>{{ $globalStockBajo }}</strong></td>
            </tr>
        </tbody>
    </table>
    
    <p style="text-align: center; margin-top: 20px; font-size: 9px; color: #666;">
        Reporte generado el {{ now()->format('d/m/Y') }} a las {{ now()->format('H:i') }}
    </p>
</div>

<div class="footer">
    HardStore MS - Reporte de Inventario | Página <span class="page-number"></span>
</div>

</body>
</html>