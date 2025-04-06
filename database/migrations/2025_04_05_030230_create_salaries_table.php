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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id('salary_id');
            $table->foreignId('salary_finance_id')
                ->constrained('finances', 'finance_id')
                ->onDelete('cascade');
            $table->foreignId('salary_employee_id')
                ->constrained('employees', 'employee_id')
                ->onDelete('cascade');
            $table->integer('salary_basic_salary');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
