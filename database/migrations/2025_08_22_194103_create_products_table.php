<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subcategory_id')->constrained('subcategories')->onDelete('cascade');
            $table->string('name'); // Te faltaba el nombre del producto
            $table->smallInteger('size')->nullable();
            // Usamos decimal para precios: 10 dígitos en total, 2 decimales
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};