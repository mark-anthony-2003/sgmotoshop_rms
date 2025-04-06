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
        Schema::create('service_transactions', function (Blueprint $table) {
            $table->id('service_transaction_id');
            $table->foreignId('service_transaction_user_id')
                ->constrained('users', 'user_id')
                ->onDelete('cascade');
            $table->foreignId('service_transaction_service_id')
                ->constrained('services', 'service_id')
                ->onDelete('cascade');
            // $table->foreignId('service_transaction_employee_id')
            //     ->constrained('employees', 'employee_id')
            //     ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_transactions');
    }
};
