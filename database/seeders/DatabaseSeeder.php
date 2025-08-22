<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llama a tu nuevo seeder aquí
        $this->call([
            UserSeeder::class,
            // Aquí puedes agregar otros seeders que crees en el futuro
        ]);
    }
}