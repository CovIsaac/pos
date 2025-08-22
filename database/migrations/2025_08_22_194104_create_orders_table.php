<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('client_name', 30);
            $table->timestamp('date_order')->useCurrent();
            $table->decimal('total', 10, 2);
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->enum('payment_method', ['card', 'cash']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};