<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->string('fee_type', 'NEW','FOLLOWUP','REVIEW','EMERGENCY','OTHER');
            $table->decimal('amount', 14, 2);
            $table->date('effective_from');
            $table->date('effective_until')->nullable();
            $table->string('status', 'ACTIVE','INACTIVE')->nullable()->default('active');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('service_id')->references('id')->on('services');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_fees');
    }
};
