<?php
// archivo: app/Observers/SubcategoryObserver.php

namespace App\Observers;

use App\Models\Product;
use App\Models\Subcategory;

class SubcategoryObserver
{
    /**
     * Handle the Subcategory "created" event.
     */
    public function created(Subcategory $subcategory): void
    {
        $this->generateProducts($subcategory);
    }

    /**
     * Handle the Subcategory "updated" event.
     */
    public function updated(Subcategory $subcategory): void
    {
        $subcategory->products()->delete();
        $this->generateProducts($subcategory);
    }

    /**
     * Genera productos basados en los tamaños de la subcategoría.
     */
    protected function generateProducts(Subcategory $subcategory): void
    {
        if (is_array($subcategory->sizes)) {
            foreach ($subcategory->sizes as $size) {
                // Verificamos que existan 'size_oz' y 'price'
                if (isset($size['size_oz']) && isset($size['price'])) {
                    Product::create([
                        'subcategory_id' => $subcategory->id,
                        'name' => $subcategory->name,
                        'size_oz' => $size['size_oz'], // Usamos el valor de onzas
                        'price' => $size['price'],
                        'image' => $subcategory->url_img,
                        'extras' => $subcategory->extras,
                    ]);
                }
            }
        }
    }
}
