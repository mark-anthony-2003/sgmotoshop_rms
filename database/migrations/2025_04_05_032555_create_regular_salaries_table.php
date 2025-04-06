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
        Schema::create('regular_salaries', function (Blueprint $table) {
            $table->id('regular_salary_id');
            $table->foreignId('regular_salary_salary_type_id')
                ->constrained('salary_types', 'salary_type_id')
                ->onDelete('cascade');
            $table->integer('regular_salary_monthly_rate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regular_salaries');
    }
};
