<?php
// PASO 2: Crea este nuevo controlador.
// archivo: app/Http/Controllers/Admin/OrderController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\PrinterController;

class OrderController extends Controller
{
    /**
     * Valida y persiste la orden en base de datos.
     */
    private function saveOrder(Request $request): Order
    {
        $validated = $request->validate([
            'customer_name'   => 'required|string|max:255',
            'total_price'     => 'required|numeric',
            'payment_method'  => 'required|string',
            'items'           => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'customer_name'  => $validated['customer_name'],
                'total_price'    => $validated['total_price'],
                'payment_method' => $validated['payment_method'],
            ]);

            foreach ($validated['items'] as $item) {
                OrderDetail::create([
                    'order_id'  => $order->id,
                    'product_id'=> $item['id'],
                    'quantity'  => $item['quantity'],
                    'price'     => $item['price'],
                ]);
            }

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function store(Request $request)
    {
        try {
            $this->saveOrder($request);
            return response()->json(['success' => true, 'message' => 'Orden guardada con éxito.']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la orden: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function finalizeAndPrint(Request $request, PrinterController $printerController)
    {
        try {
            $order = $this->saveOrder($request);
            $printerController->printOrder($order->id);

            return response()->json([
                'success' => true,
                'message' => 'Orden finalizada e impresa con éxito.',
                'order_id' => $order->id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al finalizar la orden: ' . $e->getMessage(),
            ], 500);
        }
    }
}
