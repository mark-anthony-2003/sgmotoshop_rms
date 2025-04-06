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
        Schema::create('services', function (Blueprint $table) {
            $table->id('service_id');
            $table->integer('service_total_amount');
            $table->enum('service_payment_method', [
                'cash',
                'gcash'
            ]);
            $table->enum('service_payment_status', [
                'pending',
                'completed'
            ]);
            $table->string('service_payment_ref_no')->nullable();
            $table->date('service_preferred_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
