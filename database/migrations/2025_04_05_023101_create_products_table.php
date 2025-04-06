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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->foreignId('product_user_id')
                ->constrained('users', 'user_id')
                ->onDelete('cascade');
            $table->foreignId('product_shipment_id')
                ->constrained('shipments', 'shipment_id')
                ->onDelete('cascade');
            $table->integer('product_amount');
            $table->string('product_tracking_no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
