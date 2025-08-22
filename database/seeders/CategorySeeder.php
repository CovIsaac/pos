<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category; // Asegúrate de importar el modelo User
use Illuminate\Support\Facades\Hash; // Importa el Facade para hashear la contraseña

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario Administrador
        Category::create([ 'Name'    => 'Bloody Mary']);
        Category::create([ 'Name'    => 'Clásicos con Vodka']);
        Category::create([ 'Name'    => 'Aperol']);
        Category::create([ 'Name'    => 'Sin Alcohol']);
        Category::create([ 'Name'    => 'Café']);
    }
}