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
            $table->foreignId('item_id')
                ->nullable()
                ->constrained('items', 'item_id')
                ->onDelete('cascade');
            $table->foreignId('service_transaction_id')
                ->nullable()
                ->constrained('service_transactions', 'service_transaction_id')
                ->onDelete('cascade');
            $table->foreignId('employee_id')
                ->nullable()
                ->constrained('inventories', 'inventory_id')
                ->onDelete('cascade');
            $table->foreignId('equipment_id')
                ->nullable()
                ->constrained('equipments', 'equipment_id')
                ->onDelete('cascade');
            $table->foreignId('finance_id')
                ->nullable()
                ->constrained('finances', 'finance_id')
                ->onDelete('cascade');
            $table->integer('sales');
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
