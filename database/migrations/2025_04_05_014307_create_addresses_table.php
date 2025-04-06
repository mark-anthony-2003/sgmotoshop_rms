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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id('address_id');
            $table->foreignId('address_user_id')
                ->constrained('users', 'user_id')
                ->onDelete('cascade');
            $table->string('address_barangay');
            $table->string('address_city');
            $table->string('address_province');
            $table->string('address_country');
            $table->enum('address_type', [
                'home',
                'work'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
