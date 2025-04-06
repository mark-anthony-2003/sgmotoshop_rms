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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id('inventory_id');
            $table->foreignId('inventory_product_id')
                ->constrained('products', 'product_id')
                ->onDelete('cascade');
            $table->foreignId('inventory_service_id')
                ->constrained('services', 'service_id')
                ->onDelete('cascade');
            $table->foreignId('inventory_employee_id')
                ->constrained('inventories', 'inventory_id')
                ->onDelete('cascade');
            $table->foreignId('inventory_equipment_id')
                ->constrained('equipments', 'equipment_id')
                ->onDelete('cascade');
            $table->foreignId('inventory_finance_id')
                ->constrained('finances', 'finance_id')
                ->onDelete('cascade');
            $table->integer('inventory_sales');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
