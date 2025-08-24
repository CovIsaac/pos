<?php
// Crea este nuevo archivo para la exportación a Excel.
// archivo: app/Exports/OrdersExport.php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Order::with('details.product');
        // Re-aplica tus filtros aquí...
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID Venta',
            'Cliente',
            'Total',
            'Método de Pago',
            'Fecha',
            'Productos'
        ];
    }

    public function map($order): array
    {
        $products = $order->details->map(function ($detail) {
            if (!$detail->product) return 'Producto borrado';
            return $detail->quantity . 'x ' . $detail->product->name . ' (' . $detail->product->size_oz . ' oz)';
        })->implode(', ');

        return [
            $order->id,
            $order->customer_name,
            $order->total_price,
            $order->payment_method,
            $order->created_at->format('Y-m-d H:i:s'),
            $products,
        ];
    }
}
