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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id('shipment_id');
            $table->foreignId('shipment_cart_id')
                ->constrained('carts', 'cart_id')
                ->onDelete('cascade');
            $table->unsignedBigInteger('shipment_total_amount');
            $table->enum('shipment_item_status', [
                'pending',
                'completed',
                'canceled'
            ]);
            $table->enum('shipment_method', [
                'courier',
                'on_site_pickup'
            ]);
            $table->date('shipment_date');
            $table->enum('shipment_payment_method', [
                'cash_on_delivery',
                'gcash'
            ]);
            $table->enum('shipment_payment_status', [
                'paid',
                'pending',
                'failed'
            ]);
            $table->string('shipment_payment_ref')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
