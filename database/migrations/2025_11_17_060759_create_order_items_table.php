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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

             // Relation to Orders
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->cascadeOnDelete();

            // Relation to Products
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->cascadeOnDelete();

            //  variant if exists
            $table->foreignId('variant_id')
                  ->nullable()
                  ->constrained('product_variants')
                  ->nullOnDelete();

            // Item info
            $table->integer('quantity')->default(1);

            // Price of the product at time of booking (not current product price)
            $table->decimal('price', 10, 2);

            // quantity * price
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
