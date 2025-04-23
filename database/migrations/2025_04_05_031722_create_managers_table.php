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
            $table->foreignId('position_type_id')
                ->constrained('position_types', 'position_type_id')
                ->onDelete('cascade');
            $table->foreignId('employee_id')
                ->constrained('employees', 'employee_id')
                ->onDelete('cascade');
            $table->boolean('area_checker')->default(true);
            $table->boolean('inventory_recorder')->default(true);
            $table->boolean('payroll_assistance')->default(true);
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
