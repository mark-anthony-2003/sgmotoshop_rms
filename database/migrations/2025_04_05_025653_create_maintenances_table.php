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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id('maintenance_id');
            $table->foreignId('finance_id')
                ->constrained('finances', 'finance_id')
                ->onDelete('cascade');
            $table->foreignId('equipment_id')
                ->constrained('equipments', 'equipment_id')
                ->onDelete('cascade');
            $table->string('maintenance_type_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
