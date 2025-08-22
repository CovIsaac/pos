<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 30)->unique();
            $table->string('password'); // Laravel se encarga del largo
            $table->string('role', 30)->default('customer');
            // $table->rememberToken(); // Opcional, para "recordarme"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};