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
            $table->foreignId('salary_type_id')
                ->constrained('salary_types', 'salary_type_id')
                ->onDelete('cascade');
            $table->integer('monthly_rate');
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
