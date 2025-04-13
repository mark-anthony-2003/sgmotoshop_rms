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
        Schema::create('employees', function (Blueprint $table) {
            $table->id('employee_id');
            $table->foreignId('employee_user_id')
                ->constrained('users', 'user_id')
                ->onDelete('cascade');
            $table->foreignId('employee_salary_type_id')
                ->constrained('salary_types', 'salary_type_id')
                ->onDelete('cascade');
            $table->foreignId('employee_position_type_id')
                ->constrained('position_types', 'position_type_id')
                ->onDelete('cascade');
            $table->date('employee_date_hired');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
