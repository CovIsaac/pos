<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subcategory; // Asegúrate de importar el modelo User
use Illuminate\Support\Facades\Hash; // Importa el Facade para hashear la contraseña

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subcategory::create([ 
            'category_id'    => '1',
            'name' => 'Clásico',
        ]);
        
        Subcategory::create([ 
            'category_id'    => '1',
            'name' => 'Lime',
        ]);
        Subcategory::create([ 
            'category_id'    => '1',
            'name' => 'Strawberry',
        ]);
        Subcategory::create([ 
            'category_id'    => '1',
            'name' => 'Smokey',
        ]);

    }
}