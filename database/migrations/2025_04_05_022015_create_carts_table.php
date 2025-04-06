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
        Schema::create('carts', function (Blueprint $table) {
            $table->id('cart_id');
            $table->foreignId('cart_user_id')
                ->constrained('users', 'user_id')
                ->onDelete('cascade');
            $table->foreignId('cart_item_id')
                ->constrained('items', 'item_id')
                ->onDelete('cascade');
            $table->integer('cart_quantity')->nullable();
            $table->integer('cart_sub_total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
