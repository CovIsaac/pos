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
                'name' => $flavour,
                'sizes' => [
                    ['size_oz' => 16, 'price' => 100],
                    ['size_oz' => 32, 'price' => 150],
                ],
            ]);
        }

        // Vodka options
        Subcategory::create([
            'category_id' => $categories['Vodka']->id,
            'name' => 'Vodka Tonic',
            'sizes' => [
                ['size_oz' => 16, 'price' => 130],
                ['size_oz' => 32, 'price' => 160],
            ],
        ]);

        Subcategory::create([
            'category_id' => $categories['Vodka']->id,
            'name' => 'Vodka Ricky',
            'sizes' => [
                ['size_oz' => 16, 'price' => 98],
                ['size_oz' => 32, 'price' => 138],
            ],
        ]);

        // Aperol
        Subcategory::create([
            'category_id' => $categories['Aperol']->id,
            'name' => 'Aperol',
            'sizes' => [
                ['size_oz' => 16, 'price' => 120],
            ],
        ]);

        // Sin Alcohol
        Subcategory::create([
            'category_id' => $categories['Sin Alcohol']->id,
            'name' => 'Rusa',
            'sizes' => [
                ['size_oz' => 16, 'price' => 58],
                ['size_oz' => 32, 'price' => 88],
            ],
        ]);

        // Café
        Subcategory::create([
            'category_id' => $categories['Café']->id,
            'name' => 'Café',
            'sizes' => [
                ['size_oz' => 16, 'price' => 35],
            ],
        ]);
    }
}
