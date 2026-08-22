<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointment_waitlist', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('appointment_type_id')->nullable();
            $table->date('preferred_date')->nullable();
            $table->time('preferred_start_time')->nullable();
            $table->time('preferred_end_time')->nullable();
            $table->enum('priority', ['normal', 'high', 'urgent', 'emergency'])->nullable()->default('normal');
            $table->text('notes')->nullable();
            $table->enum('status', ['waiting', 'matched', 'booked', 'skipped', 'cancelled'])->nullable()->default('waiting');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('appointment_type_id')->references('id')->on('appointment_types');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_waitlist');
    }
};
