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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id('equipment_id');
            $table->foreignId('equipment_employee_id')
                ->constrained('employees', 'employee_id')
                ->onDelete('cascade');
            $table->foreignId('equipment_service_id')
                ->constrained('services', 'service_id')
                ->onDelete('cascade');
            $table->string('equipment_name');
            $table->date('equipment_purchase_date');
            $table->date('equipment_maintenance_date');
            $table->enum('equipment_status', [
                'operational',
                'under_repair',
                'out_of_service'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
