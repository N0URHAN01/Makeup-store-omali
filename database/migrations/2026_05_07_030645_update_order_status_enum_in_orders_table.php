<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE orders 
            MODIFY status ENUM(
                'pending',
                'confirmed',
                'processing',
                'shipped',
                'out_for_delivery',
                'delivered',
                'rejected',
                'failed_delivery',
                'return_requested',
                'returned',
                'cancelled'
            ) DEFAULT 'pending'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE orders 
            MODIFY status ENUM(
                'pending',
                'confirmed',
                'shipped',
                'delivered',
                'cancelled'
            ) DEFAULT 'pending'
        ");
    }
};