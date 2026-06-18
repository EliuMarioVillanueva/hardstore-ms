<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte Filtrado</title>
</head>
<body>
    <h1>Reporte de Ventas Filtrado</h1>
    <p>Fecha inicio: {{ $fechaInicio }}</p>
    <p>Fecha fin: {{ $fechaFin }}</p>
    <p>Total de ventas: {{ $ventas->count() }}</p>
    <p>Ingresos: ${{ number_format($totalVentas, 0, ',', '.') }}</p>
</body>
</html>