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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id('expense_id');
            $table->foreignId('finance_id')
                ->constrained('finances', 'finance_id')
                ->onDelete('cascade');
            $table->foreignId('product_id')
                ->constrained('products', 'product_id')
                ->onDelete('cascade');
            $table->foreignId('service_id')
                ->constrained('services', 'service_id')
                ->onDelete('cascade');
            $table->string('expense_type');
            $table->integer('expense_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
