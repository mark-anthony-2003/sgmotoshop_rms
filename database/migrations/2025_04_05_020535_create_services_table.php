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
            $table->integer('total_amount');
            $table->date('preferred_date');
            $table->enum('payment_method', [
                'cash',
                'gcash'
            ]);
            $table->string('payment_reference')->nullable();
            $table->enum('payment_status', [
                'pending',
                'completed'
            ]);
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
