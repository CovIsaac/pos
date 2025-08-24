<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::whereIn('name', [
            'Bloody Mary',
            'Vodka',
            'Aperol',
            'Sin Alcohol',
            'Café',
        ])->get()->keyBy('name');

        // Bloody Mary flavours with common sizes
        $bloodyMaryImg = 'https://solovino.cerounocero.app/wp-content/uploads/2025/08/descargar-1.jpeg';
        foreach (['Clásico', 'Raspberry', 'Lime', 'Smokey'] as $flavour) {
            $subcategory = Subcategory::create([
                'category_id' => $categories['Bloody Mary']->id,
                'name' => $flavour,
                'url_img' => $bloodyMaryImg,
                'sizes' => [
                    ['size_oz' => 16, 'price' => 100],
                    ['size_oz' => 32, 'price' => 150],
                ],
            ]);

            foreach ($subcategory->sizes as $size) {
                Product::create([
                    'subcategory_id' => $subcategory->id,
                    'name' => $flavour,
                    'size_oz' => $size['size_oz'],
                    'price' => $size['price'],
                    'image' => $bloodyMaryImg,
                ]);
            }
        }

        // Vodka options
        $vodkaTonicImg = 'https://solovino.cerounocero.app/wp-content/uploads/2025/08/Imagen-de-WhatsApp-2025-08-14-a-las-10.41.26_926bfb76-300x300.jpg';
        $vodkaTonic = Subcategory::create([
            'category_id' => $categories['Vodka']->id,
            'name' => 'Vodka Tonic',
            'url_img' => $vodkaTonicImg,
            'sizes' => [
                ['size_oz' => 16, 'price' => 130],
                ['size_oz' => 32, 'price' => 160],
            ],
        ]);
        foreach ($vodkaTonic->sizes as $size) {
            Product::create([
                'subcategory_id' => $vodkaTonic->id,
                'name' => 'Vodka Tonic',
                'size_oz' => $size['size_oz'],
                'price' => $size['price'],
                'image' => $vodkaTonicImg,
            ]);
        }

        $vodkaRickyImg = 'https://solovino.cerounocero.app/wp-content/uploads/2025/08/Imagen-de-WhatsApp-2025-08-14-a-las-10.42.45_08407a32-300x300.jpg';
        $vodkaRicky = Subcategory::create([
            'category_id' => $categories['Vodka']->id,
            'name' => 'Vodka Ricky',
            'url_img' => $vodkaRickyImg,
            'sizes' => [
                ['size_oz' => 16, 'price' => 98],
                ['size_oz' => 32, 'price' => 138],
            ],
        ]);
        foreach ($vodkaRicky->sizes as $size) {
            Product::create([
                'subcategory_id' => $vodkaRicky->id,
                'name' => 'Vodka Ricky',
                'size_oz' => $size['size_oz'],
                'price' => $size['price'],
                'image' => $vodkaRickyImg,
            ]);
        }

        // Aperol
        $aperolImg = 'https://solovino.cerounocero.app/wp-content/uploads/2025/08/Imagen-de-WhatsApp-2025-08-13-a-las-15.35.46_b085bce9.jpg';
        $aperol = Subcategory::create([
            'category_id' => $categories['Aperol']->id,
            'name' => 'Aperol',
            'url_img' => $aperolImg,
            'sizes' => [
                ['size_oz' => 16, 'price' => 120],
            ],
        ]);
        foreach ($aperol->sizes as $size) {
            Product::create([
                'subcategory_id' => $aperol->id,
                'name' => 'Aperol',
                'size_oz' => $size['size_oz'],
                'price' => $size['price'],
                'image' => $aperolImg,
            ]);
        }

        // Sin Alcohol
        $rusaImg = 'https://solovino.cerounocero.app/wp-content/uploads/2025/08/Imagen-de-WhatsApp-2025-08-14-a-las-10.43.27_c42cf1de-300x300.jpg';
        $rusa = Subcategory::create([
            'category_id' => $categories['Sin Alcohol']->id,
            'name' => 'Rusa',
            'url_img' => $rusaImg,
            'sizes' => [
                ['size_oz' => 16, 'price' => 58],
                ['size_oz' => 32, 'price' => 88],
            ],
        ]);
        foreach ($rusa->sizes as $size) {
            Product::create([
                'subcategory_id' => $rusa->id,
                'name' => 'Rusa',
                'size_oz' => $size['size_oz'],
                'price' => $size['price'],
                'image' => $rusaImg,
            ]);
        }

        // Café
        $cafeImg = 'https://solovino.cerounocero.app/wp-content/uploads/2025/08/descargar-1-1-300x300.jpeg';
        $cafe = Subcategory::create([
            'category_id' => $categories['Café']->id,
            'name' => 'Café',
            'url_img' => $cafeImg,
            'sizes' => [
                ['size_oz' => 16, 'price' => 35],
            ],
        ]);
        foreach ($cafe->sizes as $size) {
            Product::create([
                'subcategory_id' => $cafe->id,
                'name' => 'Café',
                'size_oz' => $size['size_oz'],
                'price' => $size['price'],
                'image' => $cafeImg,
            ]);
        }
    }
}
