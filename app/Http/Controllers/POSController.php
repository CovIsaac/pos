<?php
// archivo: app/Http/Controllers/POSController.php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class POSController extends Controller
{
    /**
     * Muestra la interfaz del Punto de Venta (POS).
     */
    public function index()
    {
        // Cargamos las categorías que tienen al menos una subcategoría con productos.
        // Esto evita mostrar categorías vacías en el POS.
        $categories = Category::whereHas('subcategories.products')->with('subcategories.products')->get();
        
        return view('pos.index', compact('categories'));
    }
}
