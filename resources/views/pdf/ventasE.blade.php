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
                    <th>Cajero</th>
                    <th>Tipo</th>
                    <th>Concepto</th>
                    <th>Monto</th>                    
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                <tr>
                    <td>{{ $venta['id'] }}</td>
                    <td>{{ $venta['caja']['user']['name'] }}</td>
                    <td>{{ format_time($venta['created_at']) }}</td>
                    <td>{{ $venta['tipo'] }}</td>
                    <td>{{ $venta['concepto'] }}</td>
                    <td>Gs.{{ number_format($venta['monto'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totales -->
        <div class="totals">            
            <div><strong>Total de Ingresos:</strong> Gs.{{ number_format($ingresos, 0, ',', '.') }}</div>
            <div><strong>Total de Egresos:</strong> {{ number_format($egresos, 0, ',', '.') }} unidades</div>            
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