<?php
// archivo: app/Http/Controllers/Admin/SubcategoryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Extra;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with('category')->get();
        return view('admin.subcategories.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = Category::all();
        $extras = Extra::all();
        return view('admin.subcategories.create', compact('categories', 'extras'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:30',
            'category_id' => 'required|exists:categories,id',
            'url_img' => 'nullable|url',
            'sizes' => 'required|array',
            'sizes.*.size_oz' => 'required|numeric',
            'sizes.*.price' => 'required|numeric',
            'extras' => 'nullable|array'
        ]);

        Subcategory::create($validated);

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategoría y productos creados con éxito.');
    }

    /**
     * Muestra el formulario para editar una subcategoría.
     * Esta es la función clave que envía la variable $subcategory a la vista.
     */
    public function edit(Subcategory $subcategory)
    {
        $categories = Category::all();
        $extras = Extra::all();
        return view('admin.subcategories.edit', compact('subcategory', 'categories', 'extras'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:30',
            'category_id' => 'required|exists:categories,id',
            'url_img' => 'nullable|url',
            'sizes' => 'required|array',
            'sizes.*.size_oz' => 'required|numeric',
            'sizes.*.price' => 'required|numeric',
            'extras' => 'nullable|array'
        ]);

        $subcategory->update($validated);

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategoría y productos actualizados con éxito.');
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategoría eliminada con éxito.');
    }
}
