<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;

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
        foreach (['Clásico', 'Raspberry', 'Lime', 'Smokey'] as $flavour) {
            Subcategory::create([
                'category_id' => $categories['Bloody Mary']->id,
                'name'        => $flavour,
                'sizes'       => [
                    ['size_oz' => 16, 'price' => 100],
                    ['size_oz' => 32, 'price' => 150],
                ],
                'url_img'   => 'https://solovino.cerounocero.app/wp-content/uploads/2025/08/descargar-1.jpeg',
            ]);
        }

        // Vodka options
        Subcategory::create([
            'category_id' => $categories['Vodka']->id,
            'name'        => 'Vodka Tonic',
            'sizes'       => [
                ['size_oz' => 16, 'price' => 130],
                ['size_oz' => 32, 'price' => 160],
            ],
            'url_img'   => 'https://solovino.cerounocero.app/wp-content/uploads/2025/08/Imagen-de-WhatsApp-2025-08-14-a-las-10.41.26_926bfb76-300x300.jpg',
        ]);

        Subcategory::create([
            'category_id' => $categories['Vodka']->id,
            'name'        => 'Vodka Ricky',
            'sizes'       => [
                ['size_oz' => 16, 'price' => 100],
                ['size_oz' => 32, 'price' => 140],
            ],
            'url_img'   => 'https://solovino.cerounocero.app/wp-content/uploads/2025/08/Imagen-de-WhatsApp-2025-08-14-a-las-10.42.45_08407a32-300x300.jpg',
        ]);

        // Aperol
        Subcategory::create([
            'category_id' => $categories['Aperol']->id,
            'name'        => 'Aperol',
            'sizes'       => [
                ['size_oz' => 16, 'price' => 120],
            ],
            'url_img'   => 'https://solovino.cerounocero.app/wp-content/uploads/2025/08/Imagen-de-WhatsApp-2025-08-13-a-las-15.35.46_b085bce9.jpg',
        ]);

        // Sin Alcohol
        Subcategory::create([
            'category_id' => $categories['Sin Alcohol']->id,
            'name'        => 'Rusa',
            'sizes'       => [
                ['size_oz' => 16, 'price' => 60],
                ['size_oz' => 32, 'price' => 90],
            ],
            'url_img'   => 'https://solovino.cerounocero.app/wp-content/uploads/2025/08/Imagen-de-WhatsApp-2025-08-14-a-las-10.43.27_c42cf1de-300x300.jpg',
        ]);

        // Café
        Subcategory::create([
            'category_id' => $categories['Café']->id,
            'name'        => 'Café',
            'sizes'       => [
                ['size_oz' => 16, 'price' => 35],
            ],
            'url_img'   => 'https://solovino.cerounocero.app/wp-content/uploads/2025/08/descargar-1-1-300x300.jpeg',
        ]);
    }
}
