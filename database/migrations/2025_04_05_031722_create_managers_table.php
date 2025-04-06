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
        Schema::create('managers', function (Blueprint $table) {
            $table->id('manager_id');
            $table->foreignId('manager_position_type_id')
                ->constrained('position_types', 'position_type_id')
                ->onDelete('cascade');
            $table->boolean('manager_area_checker')->default(true);
            $table->boolean('manager_inventory_recorder')->default(true);
            $table->boolean('manager_payroll_assistance')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('managers');
    }
};
