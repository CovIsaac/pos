<?php
// archivo: app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport; // Necesitaremos crear este archivo
use Barryvdh\DomPDF\Facade\Pdf;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('details.product.subcategory.category')->latest();

        // Aplicar filtros si existen en la petición
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('category_id')) {
            $query->whereHas('details.product.subcategory.category', function ($q) use ($request) {
                $q->where('id', $request->category_id);
            });
        }
        if ($request->filled('subcategory_id')) {
            $query->whereHas('details.product.subcategory', function ($q) use ($request) {
                $q->where('id', $request->subcategory_id);
            });
        }

        $orders = $query->get();
        
        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('admin.dashboard', compact('orders', 'categories', 'subcategories'));
    }

    // Nota: Necesitarás crear el archivo App\Exports\OrdersExport.php
    // Puedes hacerlo con el comando: php artisan make:export OrdersExport --model=Order
    public function exportExcel(Request $request)
    {
        // Lógica de filtrado similar a index() para obtener los datos correctos
        // ...
        return Excel::download(new OrdersExport($request), 'ventas.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = Order::with('details.product.subcategory.category')->latest();

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        // ... otros filtros ...

        $orders = $query->get();

        $pdf = Pdf::loadView('admin.exports.orders-pdf', compact('orders'));
        return $pdf->download('reporte-ventas.pdf');
    }
}