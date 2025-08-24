<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Bloody Mary',
            'Vodka',
            'Aperol',
            'Sin Alcohol',
            'Café',
        ];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}