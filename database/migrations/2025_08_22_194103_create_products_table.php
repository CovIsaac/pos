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
            $table->string('name');
            // Store size/price pairs as JSON [{name: "Small", price: 1.99}, ...]
            $table->json('sizes');
            // Optional product image path
            $table->string('image')->nullable();
            // Array of extra option IDs associated with the product
            $table->json('extras')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};