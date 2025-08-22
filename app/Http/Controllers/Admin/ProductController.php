<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Extra;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create()
    {
        $categories = Category::with('subcategories')->get();
        $extras = Extra::all();
        return view('admin.products.create', compact('categories', 'extras'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subcategory_id' => ['required', 'exists:subcategories,id'],
            'name' => ['required', 'string', 'max:255'],
            'sizes' => ['required', 'array', 'min:1'],
            'sizes.*.name' => ['required', 'string'],
            'sizes.*.price' => ['required', 'numeric'],
            'image' => ['nullable', 'image'],
            'extras' => ['nullable', 'array'],
            'extras.*' => ['exists:extras,id'],
        ]);

        $sizes = collect($validated['sizes'])->map(function ($size) {
            return [
                'name' => $size['name'],
                'price' => (float) $size['price'],
            ];
        })->values();

        $path = $request->file('image')
            ? $request->file('image')->store('products', 'public')
            : null;

        Product::create([
            'subcategory_id' => $validated['subcategory_id'],
            'name' => $validated['name'],
            'sizes' => $sizes,
            'image' => $path,
            'extras' => $validated['extras'] ?? [],
        ]);

        return redirect()->route('admin.products.create')
            ->with('success', 'Product created.');
    }
}
