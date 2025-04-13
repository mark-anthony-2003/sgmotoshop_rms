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
        Schema::create('service_details', function (Blueprint $table) {
            $table->id('service_detail_id');
            $table->foreignId('service_detail_service_id')
                ->constrained('services', 'service_id')
                ->onDelete('cascade');
            $table->foreignId('service_detail_service_type_id')
                ->nullable()
                ->constrained('service_types', 'service_type_id')
                ->onDelete('cascade');
            $table->foreignId('service_detail_part_id')
                ->nullable()
                ->constrained('parts', 'part_id')
                ->onDelete('cascade');
                $table->foreignId('st_assigned_by_manager_id')
                ->nullable()
                ->constrained('users', 'user_id')
                ->onDelete('set null');
            $table->enum('st_approval_type', [
                'pending',
                'approved',
                'rejected'
                ])
                ->default('pending');
            $table->text('st_manager_remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_details');
    }
};
