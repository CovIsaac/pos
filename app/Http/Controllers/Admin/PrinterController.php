<?php
// archivo: app/Http/Controllers/Admin/PrinterController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use Exception;
use App\Models\Order;

class PrinterController extends Controller
{
    public function printTest()
    {
        try {
            $printerIp = '192.168.100.87';
            $connector = new NetworkPrintConnector($printerIp, 9100);
            $printer = new Printer($connector);
            $printer->text("=== PRUEBA DE IMPRESIÓN ===\n");
            $printer->feed(2);
            $printer->cut();
            $printer->close();

            return response()->json(['success' => true, 'message' => 'Impresión de prueba enviada.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'No se pudo conectar con la impresora: ' . $e->getMessage()], 500);
        }
    }

    public function printTicket(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string',
            'items_to_print' => 'required|array',
        ]);

        try {
            // Reemplaza esta IP con la de tu impresora de red
            $printerIp = '192.168.100.87'; // IP de la impresora
            $connector = new NetworkPrintConnector($printerIp, 9100);
            $printer = new Printer($connector);

            /* Margen superior */
            $printer->feed(1);

            /* Encabezado del Ticket */
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text("COMANDA\n");
            $printer->selectPrintMode();
            $printer->text("Cliente/Mesa: " . $validated['customer_name'] . "\n");
            $printer->text(now()->setTimezone('America/Mexico_City')->format('d/m/Y H:i:s') . "\n");
            $printer->feed();

            /* Cuerpo del Ticket (Productos) */
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $total = 0;
            foreach ($validated['items_to_print'] as $item) {
                $price = $item['price'] ?? 0;
                $lineTotal = ($item['quantity'] ?? 0) * $price;
                $total += $lineTotal;
                $description = ($item['quantity'] ?? 0) . 'x ' . $item['name'] . ' (' . $item['size_oz'] . 'oz)';
                $line = sprintf('%-32s %10s', $description, '$' . number_format($lineTotal, 2));
                $printer->text($line . "\n");
            }

            /* Total */
            $printer->text(str_repeat('-', 42) . "\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text(sprintf('%-12s %10s', 'TOTAL:', '$' . number_format($total, 2)) . "\n");

            /* Pie de página y corte */
            $printer->feed(3);
            $printer->cut();

            /* Cerrar conexión */
            $printer->close();

            return response()->json(['success' => true, 'message' => 'Comanda enviada a la impresora.']);

        } catch (Exception $e) {
            // Aquí sería una buena práctica registrar el error
            return response()->json(['success' => false, 'message' => 'No se pudo conectar con la impresora: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Imprime una orden existente basada en su ID.
     */
    public function printOrder(int $orderId): void
    {
        $order = Order::with('details.product')->findOrFail($orderId);

        // Reutilizamos la lógica de impresión del ticket
        try {
            $printerIp = '192.168.100.87';
            $connector = new NetworkPrintConnector($printerIp, 9100);
            $printer = new Printer($connector);

            /* Margen superior */
            $printer->feed(1);

            /* Encabezado */
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text("COMANDA\n");
            $printer->selectPrintMode();
            $printer->text('Cliente/Mesa: ' . $order->customer_name . "\n");
            $printer->text(now()->setTimezone('America/Mexico_City')->format('d/m/Y H:i:s') . "\n");
            $printer->feed();

            /* Detalles de la orden */
            $total = 0;
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            foreach ($order->details as $detail) {
                $subtotal = $detail->quantity * $detail->price;
                $total += $subtotal;
                $description = $detail->quantity . 'x ' . $detail->product->name . ' (' . $detail->product->size_oz . 'oz)';
                $line = sprintf('%-32s %10s', $description, '$' . number_format($subtotal, 2));
                $printer->text($line . "\n");
            }

            /* Total */
            $printer->text(str_repeat('-', 42) . "\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text(sprintf('%-12s %10s', 'TOTAL:', '$' . number_format($total, 2)) . "\n");

            /* Corte */
            $printer->feed(3);
            $printer->cut();
            $printer->close();
        } catch (Exception $e) {
            // En caso de error de impresión simplemente lo ignoramos o lo podríamos registrar
        }
    }
}
