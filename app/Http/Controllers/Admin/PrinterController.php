<?php
// archivo: app/Http/Controllers/Admin/PrinterController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use Exception;

class PrinterController extends Controller
{
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

            /* Encabezado del Ticket */
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text("COMANDA\n");
            $printer->selectPrintMode();
            $printer->text("Cliente: " . $validated['customer_name'] . "\n");
            $printer->text(now()->setTimezone('America/Mexico_City')->format('d/m/Y H:i:s') . "\n");
            $printer->feed();

            /* Cuerpo del Ticket (Productos) */
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            foreach ($validated['items_to_print'] as $item) {
                // Formateamos la línea para que la cantidad quede a la derecha
                $line = sprintf('%-38s %2s', $item['quantity'] . 'x ' . $item['name'] . ' (' . $item['size_oz'] . 'oz)', '');
                $printer->text($line . "\n");
            }

            /* Pie de página y corte */
            $printer->feed(2);
            $printer->cut();
            
            /* Cerrar conexión */
            $printer->close();

            return response()->json(['success' => true, 'message' => 'Comanda enviada a la impresora.']);

        } catch (Exception $e) {
            // Aquí sería una buena práctica registrar el error
            return response()->json(['success' => false, 'message' => 'No se pudo conectar con la impresora: ' . $e->getMessage()], 500);
        }
    }
}