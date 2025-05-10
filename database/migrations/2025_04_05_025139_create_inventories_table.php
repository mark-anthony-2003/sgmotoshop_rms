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
            $table->foreignId('employee_id')
                ->nullable()
                ->constrained('employees', 'employee_id')
                ->onDelete('set null');
            $table->foreignId('equipment_id')
                ->nullable()
                ->constrained('equipments', 'equipment_id')
                ->onDelete('set null');

            $table->enum('source_type', ['service_transaction', 'finance', 'sales', 'equipment', 'hr']);
            $table->unsignedBigInteger('source_id');
            $table->index(['source_type', 'source_id']);

            $table->integer('quantity')->nullable();
            $table->enum('movement_type', ['in', 'out', 'log']);
            $table->text('remarks')->nullable();

            $table->decimal('sales', 10, 2)->nullable();

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
