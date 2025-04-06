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
        Schema::create('per_day_salaries', function (Blueprint $table) {
            $table->id('per_day_salary_id');
            $table->foreignId('per_day_salary_salary_type_id')
                ->constrained('salary_types', 'salary_type_id')
                ->onDelete('cascade');
            $table->integer('per_day_salary_daily_rate');
            $table->integer('per_day_salary_days_worked');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('per_day_salaries');
    }
};
