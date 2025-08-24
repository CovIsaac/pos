<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Subcategory;
use Database\Seeders\Data\ProductData;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (ProductData::get() as $data) {
            $subcategory = Subcategory::where('name', $data['subcategory'])->first();

            if (! $subcategory) {
                continue;
            }

            Product::create([
                'subcategory_id' => $subcategory->id,
                'name' => $data['name'],
                'size_oz' => $data['size_oz'],
                'price' => $data['price'],
                'image' => $data['image'],
            ]);
        }
    }
}
