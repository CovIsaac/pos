<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Extra;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Muestra una lista de todos los productos
    public function index()
    {
        $products = Product::with('subcategory.category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // Muestra el formulario para crear un producto (ya lo tienes)
    public function create()
    {
        $categories = Category::with('subcategories')->get();
        $extras = Extra::all();
        return view('admin.products.create', compact('categories', 'extras'));
    }

    // Guarda el nuevo producto (ya lo tienes)
    public function store(Request $request)
    {
        // ... tu código de validación y guardado
        return redirect()->route('admin.products.index')->with('success', 'Producto creado exitosamente.');
    }

    // Muestra el formulario para editar un producto
    public function edit(Product $product)
    {
        $categories = Category::with('subcategories')->get();
        $extras = Extra::all();
        $productExtras = $product->extras ?? [];
        return view('admin.products.edit', compact('product', 'categories', 'extras', 'productExtras'));
    }

    // Actualiza un producto existente
    public function update(Request $request, Product $product)
    {
        // ... (añade aquí la lógica de validación y actualización, similar a store)
        // No olvides manejar la actualización de la imagen
        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado exitosamente.');
    }

    // Elimina un producto
    public function destroy(Product $product)
    {
        // Opcional: Eliminar la imagen del almacenamiento
        // if ($product->image) {
        //     Storage::disk('public')->delete($product->image);
        // }
        $product->delete();
        return back()->with('success', 'Producto eliminado exitosamente.');
    }
}