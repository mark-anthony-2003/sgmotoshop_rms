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
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropForeign(['cart_id']);
            $table->foreignId('cart_id')
                ->nullable()
                ->change();
            $table->foreign('cart_id')
                ->references('cart_id')
                ->on('carts')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropForeign(['cart_id']);
            $table->foreignId('cart_id')
                ->nullable(false)
                ->change();
            $table->foreign('cart_id')
                ->references('cart_id')
                ->on('carts')
                ->onDelete('cascade');
        });
    }
};
