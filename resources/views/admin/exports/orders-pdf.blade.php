<!-- archivo: resources/views/admin/exports/orders-pdf.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
        }
        .header .details {
            font-size: 12px;
            color: #7f8c8d;
        }
        .company-details {
            text-align: right;
            font-size: 12px;
            color: #7f8c8d;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .total-summary {
            margin-top: 20px;
            text-align: right;
        }
        .total-summary table {
            width: 300px;
            float: right;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
        }
        .products-list {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Ventas</h1>
        <div class="details">
            Generado el: {{ date('d/m/Y H:i') }}
        </div>
    </div>

    <div class="company-details">
        <strong>{{ config('app.name', 'POS System') }}</strong><br>
        Tu Dirección Aquí<br>
        Tu Teléfono Aquí
    </div>

    <br>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Método</th>
                <th>Productos</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td>{{ ucfirst($order->payment_method) }}</td>
                <td>
                    <ul class="products-list">
                    @foreach($order->details as $detail)
                        <li>{{ $detail->quantity }}x {{ $detail->product->name ?? 'N/A' }}</li>
                    @endforeach
                    </ul>
                </td>
                <td>${{ number_format($order->total_price, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">No hay ventas que mostrar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total-summary">
        <table>
            <tr>
                <th>Total de Ventas:</th>
                <td>${{ number_format($orders->sum('total_price'), 2) }}</td>
            </tr>
            <tr>
                <th>Número de Órdenes:</th>
                <td>{{ $orders->count() }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Reporte generado por el Sistema POS
    </div>
</body>
</html>