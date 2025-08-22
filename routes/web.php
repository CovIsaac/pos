<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController; // ¡Importante añadir este!

// ... (tus rutas existentes de welcome y dashboard)

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// --- Grupo de Rutas del Panel de Administración ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard del Admin
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Rutas para Productos (CRUD completo)
    Route::resource('products', ProductController::class);
    // Esto crea automáticamente las rutas para:
    // index (listar), create, store, show, edit, update, destroy
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';