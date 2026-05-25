<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas - HardStore MS</title>
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
        
        /* Encabezado de sucursal */
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
        
        /* Tabla de ventas */
        .ventas-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        
        .ventas-table th {
            background: #2c3e50;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .ventas-table td {
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
        
        /* Total de sucursal */
        .total-branch {
            text-align: right;
            margin-top: 12px;
            padding-top: 8px;
            border-top: 2px solid #0095f6;
            font-weight: bold;
            font-size: 11px;
        }
        
        /* Resumen al final (solo números, no tarjetas) */
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
        
        .estado-completado {
            color: #28a745;
            font-weight: bold;
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

@foreach($ventasPorSucursal as $index => $sede)
    @php
        $ventasDeSucursal = \App\Models\Venta::with(['usuario', 'detalles.producto'])
            ->where('sucursal_id', $sede->sucursal_id)
            ->latest()
            ->get();
        $totalSucursal = $ventasDeSucursal->sum('total');
        $numeroTransacciones = $ventasDeSucursal->count();
        $productosVendidos = $ventasDeSucursal->sum(function($v) { 
            return $v->detalles->sum('cantidad'); 
        });
    @endphp
    
    <div class="branch-report">
        <!-- Encabezado HardStore -->
        <div class="main-header">
            <h1> HardStore MS</h1>
            <p>Hardware de Alto Rendimiento</p>
        </div>
        
        <div class="fecha-generacion">
            Generado: {{ now()->format('d/m/Y H:i:s') }} | Usuario: {{ auth()->user()->name }}
        </div>
        
        <!-- Encabezado de sucursal -->
        <div class="branch-header">
            <h2>{{ strtoupper($sede->sucursal) }}</h2>
            <p>Código: SUC-{{ str_pad($sede->sucursal_id ?? $index+1, 3, '0', STR_PAD_LEFT) }}</p>
        </div>
        
        @if($ventasDeSucursal->count() > 0)
            <!-- Tabla de ventas -->
            <table class="ventas-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Venta ID</th>
                        <th>Vendedor</th>
                        <th>Producto</th>
                        <th class="text-center">Cant.</th>
                        <th class="text-right">Precio Unit.</th>
                        <th class="text-right">Subtotal</th>
                        <th class="text-center">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventasDeSucursal as $venta)
                        @foreach($venta->detalles as $detalle)
                            <tr>
                                <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                                <td>#{{ $venta->id }}</td>
                                <td>{{ $venta->usuario->name ?? 'Admin' }}</td>
                                <td>{{ $detalle->producto->name ?? 'Producto #' . $detalle->producto_id }}</td>
                                <td class="text-center">{{ $detalle->cantidad }}</td>
                                <td class="text-right">${{ number_format($detalle->precio_unitario_historico, 0, ',', '.') }}</td>
                                <td class="text-right">${{ number_format($detalle->cantidad * $detalle->precio_unitario_historico, 0, ',', '.') }}</td>
                                <td class="text-center estado-completado">COMPLETADO</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            
            <!-- Total de sucursal -->
            <div class="total-branch">
                 TOTAL {{ strtoupper($sede->sucursal) }}: ${{ number_format($totalSucursal, 0, ',', '.') }}
            </div>
            
            <!-- Resumen de la sucursal (abajo) -->
            <div class="resumen-sucursal">
                <div class="resumen-item">
                    <div class="resumen-label"> TOTAL VENTAS</div>
                    <div class="resumen-value">${{ number_format($totalSucursal, 0, ',', '.') }}</div>
                </div>
                <div class="resumen-item">
                    <div class="resumen-label"> N° TRANSACCIONES</div>
                    <div class="resumen-value">{{ $numeroTransacciones }}</div>
                </div>
                <div class="resumen-item">
                    <div class="resumen-label"> PRODUCTOS VENDIDOS</div>
                    <div class="resumen-value">{{ $productosVendidos }}</div>
                </div>
            </div>
        @else
            <p style="text-align: center; padding: 30px; color: #999;">
                No hay ventas registradas en esta sucursal
            </p>
        @endif
    </div>
@endforeach

<!-- Resumen Global al final -->
<div class="global-summary">
    <h3> Resumen General de Ventas</h3>
    <table class="global-table">
        <thead>
            <tr>
                <th>Sucursal</th>
                <th class="text-right">Total Ventas</th>
            </tr>
        </thead>
        <tbody>
            @php $granTotal = 0; @endphp
            @foreach($ventasPorSucursal as $sede)
                @php
                    $totalSucursal = \App\Models\Venta::where('sucursal_id', $sede->sucursal_id)->sum('total');
                    $granTotal += $totalSucursal;
                @endphp
                <tr>
                    <td>{{ $sede->sucursal }}</td>
                    <td class="text-right">${{ number_format($totalSucursal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="global-total">
                <td><strong>GRAN TOTAL</strong></td>
                <td class="text-right"><strong>${{ number_format($granTotal, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>
    
    <p style="text-align: center; margin-top: 20px; font-size: 9px; color: #666;">
        Reporte generado el {{ now()->format('d/m/Y') }} a las {{ now()->format('H:i') }}
    </p>
</div>

<div class="footer">
    HardStore MS - Reporte de Ventas | Página <span class="page-number"></span>
</div>

</body>
</html>