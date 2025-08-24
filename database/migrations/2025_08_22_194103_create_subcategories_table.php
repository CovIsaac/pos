<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('name', 30);
            $table->string('url_img', 255)->nullable();
            $table->json('sizes')->nullable(); // [{"name": "Chico", "price": 50}, {"name": "Grande", "price": 70}]
            $table->json('extras')->nullable(); // [1, 2, 3] (IDs de los extras)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subcategories');
    }
};