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
            $table->foreignId('cart_id')
                ->nullable()
                ->constrained('carts', 'cart_id')
                ->onDelete('set null');
            $table->unsignedBigInteger('total_amount');
            $table->enum('item_status', [
                'pending',
                'completed',
                'canceled'
            ]);
            $table->date('shipment_date');
            $table->enum('shipment_method', [
                'courier',
                'on_site_pickup'
            ]);
            $table->enum('shipment_status', [
                'in_transit',
                'delayed'
            ]);
            $table->enum('payment_method', [
                'cash_on_delivery',
                'gcash'
            ]);
            $table->enum('payment_status', [
                'paid',
                'pending',
                'failed'
            ]);
            $table->string('payment_reference')->nullable();
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
