<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Asegúrate de importar el modelo User
use Illuminate\Support\Facades\Hash; // Importa el Facade para hashear la contraseña

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario Administrador
        User::create([
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'), // Cambia 'password' por una contraseña segura
            'role'     => 'Admin',
        ]);

        // Usuario Cajero
        User::create([
            'email'    => 'caja@example.com',
            'password' => Hash::make('password'), // Cambia 'password' por una contraseña segura
            'role'     => 'Caja',
        ]);
    }
}