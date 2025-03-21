<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_item_id')->constrained('cart_items')->onDelete('cascade'); 
            $table->foreignId('cart_id')->constrained('carts')->onDelete('cascade'); 
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); 
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); 
            $table->integer('quantity');
            $table->decimal('price_at_time_of_addition', 8, 2); 
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'completed', 'canceled'])->default('pending'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
