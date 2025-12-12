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
            $table->string('order_code')->unique();

            // Customer info
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone1');
            $table->string('customer_phone2');
            $table->text('notes')->nullable();

            // Selected governorate (linked to governorates table)
            $table->foreignId('governorate_id')
                  ->constrained('governorates')
                  ->cascadeOnDelete();

             // Full delivery address
            $table->text('address');

            // Order total (after calculating all items)
            $table->decimal('shipping_cost', 8, 2)->default(0); 
            $table->decimal('total_price', 10, 2)->default(0);

            // Order status
            $table->enum('status', [
                'pending',
                'confirmed',
                'shipped',
                'delivered',
                'cancelled'
            ])->default('pending');

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
