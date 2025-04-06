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
        Schema::create('laborers', function (Blueprint $table) {
            $table->id('laborer_id');
            $table->foreignId('laborer_position_type_id')
                ->constrained('position_types', 'position_type_id')
                ->onDelete('cascade');
            $table->enum('laborer_work', [
                'Mechanic', 
                'Auto Electrician', 
                'Transmission Specialist', 
                'Welder', 
                'Tire Technician',
                'Oil Change Specialist'
            ]);
            $table->enum('laborer_employment_status', [
                'active',
                'on_leave',
                'resigned'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laborers');
    }
};
