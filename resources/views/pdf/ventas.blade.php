<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
    <style>
        /* Estilos para impresión/PDF */
        @page {
            margin: 2cm;
            size: A4;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            color: #2c3e50;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #7f8c8d;
        }

        .sales-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .sales-table th,
        .sales-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .sales-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #2c3e50;
        }

        .sales-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .product-item {
            padding: 5px 0;
            border-bottom: 1px dashed #eee;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .product-name {
            font-weight: bold;
        }

        .product-details {
            display: flex;
            justify-content: space-between;
            font-size: 0.9em;
            color: #666;
            margin-top: 3px;
        }

        .totals {
            margin-top: 30px;
            text-align: right;
            font-weight: bold;
        }

        .totals div {
            margin: 5px 0;
            font-size: 16px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 14px;
            color: #7f8c8d;
            border-top: 1px dashed #ccc;
            padding-top: 15px;
        }

        .signature {
            margin-top: 30px;
            text-align: center;
            font-style: italic;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- Encabezado -->
        <div class="header">
            <h1>REPORTE DE VENTAS</h1>
            <p>Empresa XYZ • Tel: +123 456 789 • Email: ventas@empresa.com</p>
            <p>Período: 01 de Enero de 2025 al 31 de Marzo de 2025</p>
        </div>

        <!-- Tabla de Ventas -->
        <table class="sales-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Productos</th>
                    <th>Cantidad</th>
                    <th>Precio Unit.</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                <tr>
                    <td>{{ $venta['venta']['nro_ticket'] ?? '' }}</td>
                    <td>{{ format_time($venta['venta']['created_at'] ?? now()) ?? ''}}</td>
                    <td>{{ $venta['venta']['cliente']['razon_social'] ?? '' }}</td> 
                    <td>
                        @foreach ($venta['venta']['productos'] as $index => $producto)
                        <div class="product-item">
                            <div class="product-name">{{ $producto['nombre'] }}</div>
                        </div>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($venta['venta']['detalle_ventas'] as $detalle)
                        <div class="product-item">
                            {{ $detalle['cantidad'] }}
                        </div>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($venta['venta']['detalle_ventas'] as $detalle)
                        <div class="product-item">
                            ${{ number_format($detalle['precio_unitario'], 2) }}
                        </div>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($venta['venta']['detalle_ventas'] as $detalle)
                        <div class="product-item">
                            ${{ number_format($detalle['total'], 2) }}
                        </div>
                        @endforeach
                        <div class="product-item" style="border-top: 1px solid #333; margin-top: 5px; padding-top: 5px; font-weight: bold;">
                            Total: ${{ number_format($venta['monto'], 2) }}
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totales -->
        <div class="totals">
            @php
                $totalVentas = 0;
                $totalProductos = 0;
                $nroFacturas = count($ventas);
                
                foreach ($ventas as $venta) {
                    $totalVentas += $venta['monto'];
                    foreach ($venta['venta']['detalle_ventas'] as $detalle) {
                        $totalProductos += $detalle['cantidad'];
                    }
                }
            @endphp
            <div><strong>Total de Ventas:</strong> ${{ number_format($totalVentas, 2) }}</div>
            <div><strong>Total de Productos Vendidos:</strong> {{ $totalProductos }} unidades</div>
            <div><strong>Número de Facturas:</strong> {{ $nroFacturas }}</div>
        </div>

        <!-- Firma -->
        <div class="signature">
            ___________________________<br>
            Gerente de Ventas<br>
            Empresa XYZ
        </div>

        <!-- Pie de página -->
        <div class="footer">
            &copy; 2025 Empresa XYZ. Todos los derechos reservados. • Generado el {{ format_time(now()) }}
        </div>

    </div>
</body>
</html>