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
        Schema::table('employees', function (Blueprint $table) {
            $table->foreignId('employee_service_transaction_id')
                ->nullable()
                ->constrained('service_transactions', 'service_transaction_id')
                ->onDelete('cascade');
        });

        Schema::table('service_transactions', function (Blueprint $table) {
            $table->foreignId('service_transaction_employee_id')
                ->nullable()
                ->constrained('employees', 'employee_id')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['employee_service_transaction_id']);
            $table->dropColumn('employee_service_transaction_id');
        });

        Schema::table('service_transactions', function (Blueprint $table) {
            $table->dropForeign(['service_transaction_employee_id']);
            $table->dropColumn('service_transaction_employee_id');
        });
    }
};
