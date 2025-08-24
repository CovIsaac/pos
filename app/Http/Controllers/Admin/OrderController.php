<?php
// PASO 2: Crea este nuevo controlador.
// archivo: app/Http/Controllers/Admin/OrderController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'total_price' => 'required|numeric',
            'payment_method' => 'required|string',
            'items' => 'required|array'
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'total_price' => $validated['total_price'],
                'payment_method' => $validated['payment_method'],
            ]);

            foreach ($validated['items'] as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Orden guardada con éxito.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error al guardar la orden: ' . $e->getMessage()], 500);
        }
    }
}
